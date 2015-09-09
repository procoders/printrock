<?php
    $id = uniqid();
    AssetManager::addScript('admin::js/lightbox-2.6.min.js');
    AssetManager::addStyle('admin::css/lightbox.css');
?>

<div class="panel-group" id="accordion">
    @foreach ($itemsField as $key => $item)
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove" data-original-title="" title=""><i class="fa fa-times"></i></a>
                </div>
                <h3 class="panel-title">
                    <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion" href="#collapse_{{$key}}">
                        <i class="fa fa-plus-circle pull-right"></i>
                        Item {{$key + 1}}
                    </a>
                </h3>
            </div>
            <div id="collapse_{{$key}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_{{$key}}">
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-md-2 control-label">Photo</label>
                        <div class="col-md-10">
                            <a href="/{{$photos[$key]->image}}" data-lightbox="{{$id}}">
                                <img class="thumbnail" src="/{{$photos[$key]->image}}" width="200px">
                            </a>
                        </div>
                    </div>
                    @foreach ($item as $field)
                        {!!$field!!}
                    @endforeach
                    <div class="form-group">
                        <label class="col-md-2 control-label">Addons</label>
                        <div class="col-md-10">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th>Price Type</th>
                                            <th>Price</th>
                                            <th>Qty</th>
                                        </tr>
                                        </thead>
                                            @foreach ($addons as $addon)
                                                <tr>
                                                    <td><input type="checkbox" name="items[{{$key}}][addons][]" value="{{$addon->id}}" @if (isset($itemsAddons[$key][$addon->id])) checked="checked" @endif /></td>
                                                    <td>{{$addon->name}}</td>
                                                    <td>{{$addon->type()->first()->name}} ({{$addon->type()->first()->code}})</td>
                                                    <td>{{$addon->price_type}}</td>
                                                    <td>{{$addon->price}}</td>
                                                    <td>
                                                        <input type="text" name="" value="@if (isset($itemsAddons[$key][$addon->id])) {{$itemsAddons[$key][$addon->id]}} @else 0 @endif" />
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>