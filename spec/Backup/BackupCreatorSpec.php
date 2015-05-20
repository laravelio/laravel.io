<?php
namespace spec\Lio\Backup;

use BigName\BackupManager\Manager;
use BigName\BackupManager\Procedures\BackupProcedure;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BackupCreatorSpec extends ObjectBehavior
{
    function let(Manager $manager)
    {
        $this->beConstructedWith($manager, 'mysql', 'local');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Lio\Backup\BackupCreator');
    }

    function it_can_create_backups_for_production(Manager $manager, BackupProcedure $procedure)
    {
        $file = date('Y-m-d-H-i-s') . '_backup.sql';
        $manager->makeBackup()->willReturn($procedure);
        $procedure->run('mysql', 's3', $file, 'gzip')->shouldBeCalled();

        $this->beConstructedWith($manager, 'mysql', 's3');

        $this->create()->shouldReturn($file . '.gz');
    }

    function it_can_create_backups_for_local(Manager $manager, BackupProcedure $procedure)
    {
        $file = date('Y-m-d-H-i-s') . '_backup.sql';
        $manager->makeBackup()->willReturn($procedure);
        $procedure->run('mysql', 'local', $file, 'gzip')->shouldBeCalled();

        $this->beConstructedWith($manager, 'mysql', 'local');

        $this->create()->shouldReturn($file . '.gz');
    }
}
