<?php
    AssetManager::addScript('admin::js/lightbox-2.6.min.js');
    AssetManager::addStyle('admin::css/lightbox.css');
?>

<div class="form-group">
    <label class="col-md-2 control-label">{{$label}}</label>
    <div class="col-md-10">
        <table class="table">
            <col width="100px">
            <col width="100px">
            <thead>
            <tr>
                <td>{{trans('admin.images.edit.images')}}</td>
                <td>{{trans('admin.images.edit.action')}}</td>
            </tr>
            </thead>
            <tbody>
                @if (!empty($imagePath))
                <tr class="img-container">
                    <td>
                        <input type="hidden" name="image" value="{{$imagePath}}">
                        <a href="{{$imagePath}}" data-lightbox="img-popup">
                            <img class="thumbnail" src="{{$imagePath}}" width="150px">
                        </a>
                    </td>
                </tr>
                @endif
                <tr>
                    <td colspan="2">
                        <input type="file" accept="image/*" id="imgInputField" name="image" class="file file-loading" data-preview-file-type="text" style="width: 100%">
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<script>
    $("#imgInputField").fileinput({ uploadAsync: false });
    $("#imgInputField").change(function() {
        var val = $("#imgInputField").val();

        if (val.length > 0) {
            $('.img-container a').hide();
        }
    });
</script>