<div class="editor-container">
    <?php $placeholder = Auth::check() ? null : 'Please login first before using the pastebin.' ?>
    <?php $disabled = Auth::check() ? [] : ['disabled' => 'disabled'] ?>
    {{ Form::textarea('code', $placeholder, array_merge(['class' => 'editor mousetrap', 'wrap' => 'off'], $disabled)) }}
    <input type="text" name="password" style="position:absolute;top:-200px;left:0;">
</div>