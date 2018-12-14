@extends('Zoroaster::layout')

@section('content')
    <div class="uk-card card">

        <h1 class="resourceName">{{ $resourceClass->labels }}</h1>
        <div class="uk-child-width-1-2 resourceName_2" uk-grid>
            <div>
                <form class="uk-search">
                    <button uk-search-icon></button>
                    <input class="uk-search-input" type="search" name="search" value="{{ request()->search }}" placeholder="Search...">
                </form>
            </div>
            <div class="uk-text-left">
                <a href="{{ route('Zoroaster.resource.create',['resoure'=> $request->resourceClass]) }}" class="btn uk-button uk-button-primary uk-border-rounded">اضافه
                    کردن {{ $resourceClass->label }}</a>
            </div>
        </div>
        <div class="card-w">
            @if(count($resources) != 0)

                <div class="uk-child-width-1-2 resourceName_3" uk-grid>
                    <div>
                        <div class="select_row uk-icon">
                            <input class="uk-checkbox key_dataTable" type="checkbox">
                        </div>
                    </div>
                    <div class="uk-text-left">

                        <div class="uk-display-inline-block">
                            <div class="filter-selector bg-hover uk-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" aria-labelledby="filter" role="presentation" class="fill-current text-80">
                                    <path fill-rule="nonzero"
                                          d="M.293 5.707A1 1 0 0 1 0 4.999V1A1 1 0 0 1 1 0h18a1 1 0 0 1 1 1v4a1 1 0 0 1-.293.707L13 12.413v2.585a1 1 0 0 1-.293.708l-4 4c-.63.629-1.707.183-1.707-.708v-6.585L.293 5.707zM2 2v2.585l6.707 6.707a1 1 0 0 1 .293.707v4.585l2-2V12a1 1 0 0 1 .293-.707L18 4.585V2H2z"></path>
                                </svg>
                                <svg width="10px" height="6px" viewBox="0 0 10 6" version="1.1" xmlns="http://www.w3.org/2000/svg" class="ml-2">
                                    <g stroke="none" stroke-width="1" fill-rule="evenodd">
                                        <g id="04-user" transform="translate(-385.000000, -573.000000)" fill-rule="nonzero">
                                            <path d="M393.292893,573.292893 C393.683418,572.902369 394.316582,572.902369 394.707107,573.292893 C395.097631,573.683418 395.097631,574.316582 394.707107,574.707107 L390.707107,578.707107 C390.316582,579.097631 389.683418,579.097631 389.292893,578.707107 L385.292893,574.707107 C384.902369,574.316582 384.902369,573.683418 385.292893,573.292893 C385.683418,572.902369 386.316582,572.902369 386.707107,573.292893 L390,576.585786 L393.292893,573.292893 Z"
                                                  id="Path-2-Copy">
                                            </path>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            <div uk-dropdown="mode: click">

                                {!! Zoroaster::Filters($request) !!}

                            </div>
                        </div>

                        {!! Zoroaster::ResourceActions($request,null,$model,'IndexTopLeft',null) !!}

                    </div>
                </div>

                <table class="uk-table dataTables uk-table-middle">
                    <thead>
                    <tr role="row">
                        <th></th>
                        @foreach($fields as $field)
                            <th data-sortable_field="{{ $field->name }}" data-sortable="{{ (request()->sortable_field == $field->name)? request()->sortable_direction : '' }}"
                                class=" {{ $field->sortable? 'cursor-pointer': ''}}"
                                style="width: 59px;text-align: {{ $field->textAlign }}">{{ $field->label }}
                                @if ($field->sortable == true)
                                    <div class="sortable">
                                        <span uk-icon="cheveron-up"></span>
                                        <span uk-icon="cheveron-down" cheveron-checked="1"></span>
                                    </div>
                                @endif
                            </th>
                        @endforeach
                        <th style="width: 134px;text-align: center">
                            عملیات
                        </th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($resources as $data)
                        <tr destroy-resourceId="{{ $data->{$model->getKeyName()} }}">
                            <td style="width: 32px;">
                                <input name="{{ $model->getKeyName() }}[]" value="{{ $data->{$model->getKeyName()} }}"
                                       class="uk-checkbox key_dataTable_2 key_dataTable_{{ $model->getKeyName() }}"
                                       type="checkbox">
                            </td>

                            @foreach($fields as $field)

                                <td style="text-align: {{ $field->textAlign }}" class="uk-text-nowrap">{!! $field->viewIndex($data,$field) !!}</td>

                            @endforeach

                            <td class="action_btn" style="text-align: center">
                                {!! Zoroaster::ResourceActions($request,$data,$model,'Index',$field) !!}
                            </td>

                        </tr>
                    @endforeach

                    </tbody>
                </table>

                <div class="dataTables_info uk-child-width-1-3" uk-grid>
                    <div class="dataTables_paginate">
                        @if (!$resources->onFirstPage())
                            <a href="{{ $resources->previousPageUrl() }}"><span class="uk-margin-small-right uk-margin-small-left" uk-pagination-previous></span> قبلی</a>
                        @endif
                    </div>
                    <div class="uk-text-center"> نمایش {{ $resources->firstItem() }} تا {{ $resources->lastItem() }} از {{ $resources->total() }}
                        رکورد
                    </div>
                    <div class="uk-text-left dataTables_paginate">
                        @if ($resources->hasMorePages())
                            <a href="{{ $resources->nextPageUrl() }}">بعدی <span class="uk-margin-small-left uk-margin-small-right" uk-pagination-next></span></a>
                        @endif
                    </div>
                </div>


            @else
                <div class="noCountResources">
                    <span uk-icon="icon: plus-circle; ratio: 2"></span>
                    <div class="text">هیچ {{ $resourceClass->label }}ی پیدا نشد</div>
                    <a href="{{ route('Zoroaster.resource.create',['resoure'=> $request->resourceClass]) }}" class="btn uk-button uk-button-primary uk-border-rounded">اضافه
                        کردن {{ $resourceClass->label }}</a>
                </div>
            @endif

        </div>
    </div>


    <script>
        $(document).on('click', '.dataTables th', function () {

            $this = $(this);


            var name = $this.attr('data-sortable_field');
            var sort = $this.attr('data-sortable');

            console.log(sort);
            switch (sort) {
                case '':
                    sort = 'desc';
                    break;

                case 'desc':
                    sort = 'asc';
                    break;

                case 'asc':
                    sort = 'desc';
                    break;
            }

            setParameter([
                ['sortable_direction', sort],
                ['sortable_field', name],
            ]);

        });


        $(document).ready(function () {
            $(document).on('change', '.key_dataTable', function () {

                if ($(this).is(':checked'))
                    $('.key_dataTable_{{ $model->getKeyName() }}').prop('checked', true);
                else
                    $('.key_dataTable_{{ $model->getKeyName() }}').prop('checked', false);


            });

            $(document).on('click', '.ForceDeleting', function () {

                $this = $(this);

                UIkit.modal.confirm(
                    '<h2>حذف رکورد</h2>' +
                    '<h3>شما دارید این رکورد رو حذف می کنید مطمئن هستید</h3>'
                    , {
                        labels: {ok: 'حذف', cancel: 'خیر'},
                        addClass: 'modal_delete'
                    }).then(function () {
                    Destroy([$this.attr('resourceId')]);
                });

            });

            $(document).on('click', '.softDeleting', function () {

                $this = $(this);

                UIkit.modal.confirm(
                    '<h2>حذف رکورد</h2>' +
                    '<h3>شما دارید این رکورد رو حذف می کنید مطمئن هستید</h3>'
                    , {
                        labels: {ok: 'حذف', cancel: 'خیر'},
                        addClass: 'modal_delete'
                    }).then(function () {
                    DestroySoftDeleting([$this.attr('resourceId')]);
                });

            });

            $(document).on('click', '.restore-one-resource', function () {

                $this = $(this);

                UIkit.modal.confirm(
                    '<h2>بازیابی رکورد</h2>' +
                    '<h3>شما دارید این رکورد رو بازیابی می کنید مطمئن هستید</h3>'
                    , {
                        labels: {ok: 'بله', cancel: 'خیر'},
                        addClass: 'modal_restore'
                    }).then(function () {
                    Restore([$this.attr('resourceId')]);
                });

            });


        });


        function Destroy($resourceId) {
            $destroy_resourceId = $resourceId;

            $.each($destroy_resourceId, function (_key, _value) {
                $('[destroy-resourceId="' + _value + '"]').addClass('destroy-resourceid');
            });

            $.ajax({
                type: 'DELETE',
                url: '{{ route('Zoroaster.resource.destroy',['resource'=> $request->resourceClass ]) }}',
                data: {
                    _token: $('meta[name="_token"]').attr('content'),
                    resourceId: $destroy_resourceId
                },
                success: function (data) {
                    console.log(data);
                    $.each($destroy_resourceId, function (_key, _value) {
                        $('[destroy-resourceId="' + _value + '"]').remove();
                    });

                },
                error: function (data) {

                    var errors = data.responseJSON;
                    console.log(errors.errors);

                    // $.each(errors.errors, function (key, item) {
                    //     errorsHtml += '<li>' + item + '</li>'; //showing only the first error.
                    // });

                }
            });
        }


        function DestroySoftDeleting($resourceId) {
            $destroy_resourceId = $resourceId;

            $.each($destroy_resourceId, function (_key, _value) {
                $('[destroy-resourceId="' + _value + '"]').addClass('destroy-resourceid');
            });

            $.ajax({
                type: 'POST',
                url: '{{ route('Zoroaster.resource.softDeleting',['resource'=> $request->resourceClass ]) }}',
                data: {
                    _token: $('meta[name="_token"]').attr('content'),
                    resourceId: $destroy_resourceId
                },
                success: function (data) {
                    // console.log(data);
                    $.each(data, function (_key, _value) {
                        var destroy = $('[destroy-resourceId="' + _value.id + '"]');
                        destroy.find('.action_btn').html(_value.col);
                        destroy.removeClass('destroy-resourceid');
                    });

                },
                error: function (data) {

                    var errors = data.responseJSON;
                    console.log(errors.errors);

                    // $.each(errors.errors, function (key, item) {
                    //     errorsHtml += '<li>' + item + '</li>'; //showing only the first error.
                    // });

                }
            });
        }


        function Restore($resourceId) {
            $destroy_resourceId = $resourceId;

            $.each($destroy_resourceId, function (_key, _value) {
                $('[destroy-resourceId="' + _value + '"]').addClass('Restore-resourceid');
            });

            $.ajax({
                type: 'PUT',
                url: '{{ route('Zoroaster.resource.restore',['resource'=> $request->resourceClass ]) }}',
                data: {
                    _token: $('meta[name="_token"]').attr('content'),
                    resourceId: $destroy_resourceId
                },
                success: function (data) {
                    // console.log(data);
                    $.each(data, function (_key, _value) {
                        var destroy = $('[destroy-resourceId="' + _value.id + '"]');
                        destroy.find('.action_btn').html(_value.col);
                        destroy.removeClass('Restore-resourceid');
                    });

                },
                error: function (data) {

                    var errors = data.responseJSON;
                    console.log(errors.errors);

                    // $.each(errors.errors, function (key, item) {
                    //     errorsHtml += '<li>' + item + '</li>'; //showing only the first error.
                    // });

                }
            });
        }


        function setGetParameter(paramName, paramValue, redirect = true) {
            var url = window.location.href;
            var hash = location.hash;
            url = url.replace(hash, '');
            if (url.indexOf(paramName + "=") >= 0) {
                var prefix = url.substring(0, url.indexOf(paramName));
                var suffix = url.substring(url.indexOf(paramName));
                suffix = suffix.substring(suffix.indexOf("=") + 1);
                suffix = (suffix.indexOf("&") >= 0) ? suffix.substring(suffix.indexOf("&")) : "";
                url = prefix + paramName + "=" + paramValue + suffix;
            }
            else {
                if (url.indexOf("?") < 0)
                    url += "?" + paramName + "=" + paramValue;
                else
                    url += "&" + paramName + "=" + paramValue;
            }

            if (redirect)
                window.location.href = url + hash;
        }


        function setParameter(param) {
            var url = window.location.href;
            var hash = location.hash;
            $.each(param, function (key, value) {
                url = url.replace(hash, '');
                if (url.indexOf(value[0] + "=") >= 0) {
                    var prefix = url.substring(0, url.indexOf(value[0]));
                    var suffix = url.substring(url.indexOf(value[0]));
                    suffix = suffix.substring(suffix.indexOf("=") + 1);
                    suffix = (suffix.indexOf("&") >= 0) ? suffix.substring(suffix.indexOf("&")) : "";
                    url = prefix + value[0] + "=" + value[1] + suffix;
                }
                else {
                    if (url.indexOf("?") < 0)
                        url += "?" + value[0] + "=" + value[1];
                    else
                        url += "&" + value[0] + "=" + value[1];
                }

            });
            window.location.href = url + hash;
        }
    </script>

@endsection