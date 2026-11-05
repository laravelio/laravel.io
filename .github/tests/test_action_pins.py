import pathlib
import subprocess
import tempfile
import unittest


CHECKER = pathlib.Path(__file__).resolve().parents[1] / "check-action-pins.php"
SHA = "0123456789abcdef" * 2 + "01234567"
DIGEST = "0123456789abcdef" * 4


class ActionPinsTest(unittest.TestCase):
    def check_yaml(self, source, accepted):
        with tempfile.TemporaryDirectory() as directory:
            workflow = pathlib.Path(directory) / "workflow.yml"
            workflow.write_text(source)
            result = subprocess.run(
                ["php", str(CHECKER), str(workflow)], capture_output=True, text=True
            )
        self.assertEqual(result.returncode, 0 if accepted else 1, result.stderr)

    def test_allowed_references(self):
        for reference in [
            f"actions/checkout@{SHA}",
            f"owner/repo/sub/action@{SHA}",
            f"owner/repo/.github/workflows/tests.yml@{SHA}",
            "./.github/actions/build",
            "./.github/workflows/tests.yml",
            f"docker://alpine@sha256:{DIGEST}",
            f"docker://registry.example:5000/image:tag@sha256:{DIGEST}",
        ]:
            with self.subTest(reference=reference):
                self.check_yaml(f"jobs:\n  job:\n    uses: '{reference}' # version\n", True)

    def test_rejected_references(self):
        for reference in [
            "actions/checkout@v7",
            "actions/checkout@main",
            f"actions/checkout@{SHA[:7]}",
            f"actions/checkout@{SHA}extra",
            f"owner/repo/.github/workflows/tests.yml@main",
            "docker://alpine:latest",
            f"docker://alpine@{SHA}",
            f"docker://alpine@sha256:{DIGEST[:-1]}",
            f"docker://alpine@sha256:{'z' * 64}",
            ".not-a-local-action@main",
            "${{ inputs.action }}",
            "",
        ]:
            with self.subTest(reference=reference):
                self.check_yaml(f"jobs:\n  job:\n    steps:\n      - uses: '{reference}'\n", False)

    def test_yaml_not_line_matching(self):
        self.check_yaml('jobs: {job: {steps: [{"uses": "actions/checkout@v7"}]}}', False)
        self.check_yaml('jobs:\n  job:\n    uses: >-\n      owner/repo/workflow.yml@main\n', False)
        self.check_yaml(f'jobs: {{job: {{"uses": "owner/repo/workflow.yml@{SHA}"}}}}', True)
        self.check_yaml('jobs:\n  job:\n    steps:\n      - run: |\n          echo "uses: actions/checkout@v7"\n', True)

    def test_invalid_yaml_fails_closed(self):
        self.check_yaml("jobs: [", False)
        self.check_yaml("jobs: {job: {uses: false}}", False)
