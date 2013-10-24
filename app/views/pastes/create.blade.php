<div id="drop_zone" style='border: 1px; border-style:solid; height:100px;'>Drop files here</div>
<output id="list"></output>

@section('scripts')
  @parent

  <script src="{{ asset('javascripts/bin.js') }}"></script>
@stop

<ul class="_files">
</ul>

<div style='display:none;' class="_file_template">
  <li class="file">
    <span>|filename|</span>
    <textarea>|contents|</textarea>
  </li>
</div>