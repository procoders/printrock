<?php
    $id = uniqid();
    AssetManager::addScript('admin::js/lightbox-2.6.min.js');
    AssetManager::addStyle('admin::css/lightbox.css');
?>

<div class="form-group">
    <label class="col-md-2 control-label">{{trans('admin.hotels.edit.images')}}</label>
    <div class="col-md-10">
        <table class="table">
            <col width="100px">
            <col width="100px">
            <thead>
            <tr>
                <td>{{trans('admin.hotels.edit.images')}}</td>
                <td>{{trans('admin.hotels.edit.action')}}</td>
            </tr>
            </thead>
            <tbody>
            @foreach ($images as $image)
                <tr class="img-container">
                    <td>
                        <input type="hidden" name="edit_images[]" value="{{$image->id}}">
                        <a href="/{{$image->image}}" data-lightbox="{{$id}}">
                            <img class="thumbnail" src="/{{$image->image}}" width="150px">
                        </a>
                    </td>
                    <td>
                        <a href="#" class="img-delete" data-name="photo">
                            <i class="fa fa-times"></i> {{trans('admin.hotels.edit.delete')}}
                        </a>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4">
                    <input type="file" accept="image/*" id="teq" name="images[]" multiple class="file file-loading" data-preview-file-type="text" style="width: 100%">
                    <script>
                        $("#teq").fileinput({
                            uploadAsync: false
                        });
                    </script>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<script>
    $('.img-delete').click(function() {
        $(this).parents('.img-container:first').hide();
        return false;
    });
</script>