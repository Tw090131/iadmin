@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @role('admin')
                    <p>This is visible to users with the admin role. Gets translated to
                        \Entrust::role('admin')</p>
                    @endrole

                    @permission('create users')
                    <p>This is visible to users with the given permissions. Gets translated to
                        \Entrust::role('admin')</p>
                    @endpermission

                    {{--@ability('admin,owner', 'create-post,edit-user')--}}
                    {{--<p>This is visible to users with the given abilities. Gets translated to--}}
                        {{--\Entrust::ability('admin,owner', 'create-post,edit-user')</p>--}}
                    {{--@endability--}}
                </div>


            </div>
        </div>
    </div>
</div>
@endsection
