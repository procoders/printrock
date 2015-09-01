<?php
$langId = uniqid();
?>
<script>
    (function($) {
        var MutationObserver = window.MutationObserver || window.WebKitMutationObserver || window.MozMutationObserver;

        $.fn.attrchange = function(callback) {
            if (MutationObserver) {
                var options = {
                    subtree: false,
                    attributes: true
                };

                var observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(e) {
                        callback.call(e.target, e.attributeName);
                    });
                });

                return this.each(function() {
                    observer.observe(this, options);
                });

            }
        }
    })(jQuery);
    jQuery(document).ready(function() {
        jQuery('#{{$langId}} input').attrchange(function(attrName) {
            if(attrName=='class'){
                var element = jQuery('#{{$langId}} .parsley-error').eq(0);
                if (element.length > 0) {
                    var focused = jQuery(document.activeElement);
                    if (focused.closest('#{{$langId}}').length > 0) {
                        return false;
                    }
                    jQuery('#{{$langId}} .nav-tabs li').removeClass('active');
                    jQuery('#{{$langId}} .tab-pane').removeClass('active');
                    var tab = jQuery(element).closest('.tab-pane');
                    var tabId = tab.data('tab');
                    jQuery('#' + tabId).addClass('active');
                    tab.removeClass('fade');
                    tab.addClass('active');
                }
            }

        });
    })
</script>
<style>
    ul.descTab {
        background: #242a30;
    }
    ul.descTab a {
        color: white;
    }
    ul.descTab li.active a{
        color: #242a30;
    }
    .descTabContent {
        border: 1px solid #242a30;
        border-top: none;
    }
    ul.descTab li{
        padding: 1px 0 0 1px;
    }
    textarea {
        width: 100%;
    }
</style>
@if (!is_null($title))
    <div class="form-group" id="{{$langId}}">
        <label class="col-md-2 control-label">{{$title}}</label>
        <div class="col-md-10">
            @if ($withTabs)
                <ul class="nav nav-tabs descTab" id="{{$blockId}}">
                    @foreach ($languages as $index => $language)
                        <li @if ($index == 0) class="active tab-item" @else class="tab-item" @endif id="{{$blockId}}_nav_{{$language->id}}" >
                            <a data-toggle="tab" href="#{{$code}}_{{$language->id}}">{{$language->name}}</a>
                        </li>
                    @endforeach
                </ul>
                <div class="tab-content descTabContent" id="{{$blockId}}_content">
                    @foreach ($languages as $index => $language)
                        <div id="{{$code}}_{{$language->id}}" class="tab-pane @if ($index == 0) active @else fade @endif" data-tab="{{$blockId}}_nav_{{$language->id}}">
                            @foreach ($fields[$language->id] as $field)
                                {!!$field!!}
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @else
                @foreach ($languages as $index => $language)
                    @foreach ($fields[$language->id] as $field)
                        {!!$field!!}
                    @endforeach
                @endforeach
            @endif
        </div>
    </div>
@else
    <div class="col-md-12" id="{{$langId}}">
        @if ($withTabs)
            <ul class="nav nav-tabs descTab" id="{{$blockId}}">
                @foreach ($languages as $index => $language)
                    <li @if ($index == 0) class="active tab-item" @else class="tab-item" @endif id="{{$blockId}}_nav_{{$language->id}}" >
                        <a data-toggle="tab" href="#{{$code}}_{{$language->id}}">{{$language->name}}</a>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content descTabContent" id="{{$blockId}}_content">
                @foreach ($languages as $index => $language)
                    <div id="{{$code}}_{{$language->id}}" class="tab-pane @if ($index == 0) active @else fade @endif" data-tab="{{$blockId}}_nav_{{$language->id}}">
                        @foreach ($fields[$language->id] as $field)
                            {!!$field!!}
                        @endforeach
                    </div>
                @endforeach
            </div>
        @else
            @foreach ($languages as $index => $language)
                @foreach ($fields[$language->id] as $field)
                    {!!$field!!}
                @endforeach
            @endforeach
        @endif
    </div>
@endif