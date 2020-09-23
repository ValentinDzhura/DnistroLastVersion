@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.arrival.actions.create'))

@section('body')

    <div class="container-xl">

                <div class="card">
        
        <arrival-form
            :action="'{{ url('admin/arrivals') }}'"
            v-cloak
            inline-template>

            <form class="form-horizontal form-create" method="post" @submit.prevent="onSubmit" :action="action" novalidate>
                
                <div class="card-header">
                    <i class="fa fa-plus"></i> {{ trans('admin.arrival.actions.create') }}
                </div>

                <div class="card-body">
                    @include('admin.arrival.components.form-elements')

                                            <div class="dynamic_fields">
                                                <div class="example_student">
                                                    <div class="table">
                                                    <label for="tour_name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">Documents</label>
                                                        <div class="cell"><input class="form-control" type="text" name="documents[]"/></div>
                                                        <div class="cell">
                                                            <div class="js-remove pull-right btn btn-danger">-</div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="students"></div>

                                                <div class="js-add pull-right btn btn-success">+</div>






                </div>
                                
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" :disabled="submiting">
                        <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                        {{ trans('brackets/admin-ui::admin.btn.save') }}
                    </button>
                </div>
                
            </form>

        </arrival-form>

        </div>

        </div>



@endsection

