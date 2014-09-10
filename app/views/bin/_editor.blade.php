<div class="editor-container">
    {{ Form::textarea('code', null, ['class' => 'editor mousetrap', 'wrap' => 'off']) }}
</div>
<div id="subjectDiv" style="position: absolute; bottom: 0;left: 0;">
    <label for="foo">Leave this field blank</label>
    <input type="text" name="subject" id="subject">
</div>
<script>
(function () {
    var e = document.getElementById("subjectDiv");
    e.parentNode.removeChild(e);
})();
</script>