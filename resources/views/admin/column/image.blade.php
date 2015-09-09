@if (! $src)
    <td></td>
@else
    <td>
        <a href="/{{$src}}" data-lightbox="{{$src}}">
            <img class="thumbnail" src="/{{$src}}" width="150px" />
        </a>
    </td>
    <?php
    AssetManager::addScript('admin::js/lightbox-2.6.min.js');
    AssetManager::addStyle('admin::css/lightbox.css');
    ?>
@endif