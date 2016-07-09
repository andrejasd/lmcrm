<div class="">
    <div class="togglebutton">
      <label>
        <input type="checkbox" @if($status) checked="checked" @endif disabled="disabled">
        @if($status) @lang('admin/admin.yes') @else @lang('admin/admin.no') @endif
      </label>
  </div>
</div>
<script type="text/javascript">$.material.init(".togglebutton")</script>