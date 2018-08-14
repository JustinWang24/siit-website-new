@extends('layouts.backend')

@section('content')
    <div id="intake-manager-app" class="invisible">
        <br>
        <div class="columns">
            <div class="column">
                <h2 class="is-size-4">
                    Step 2: manage intake items - {{ $intake->title }} ({{ $intake->online_date->format('d-M-Y') }})
                </h2>
            </div>
            <div class="column">
                <a class="button is-primary pull-right" href="{{ url('/backend/intakes/edit/'.$intake->id) }}"><i class="fas fa-arrow-left"></i>&nbsp;Back</a>
            </div>
        </div>

        <div class="container">
            <el-form ref="currentPage" status-icon :model="currentPage" id="intake-items-form" action="{{ url('/backend/intakes/save-items') }}" method="post">
                <input type="hidden" name="in_take_id" value="{{ $intake->id }}">
                @csrf
                @foreach($languages as $key => $language)
                    <?php
                        $currentItemId = null;
                        $currentItemScheduled = null;
                        $currentSeats = null;
                        foreach ($intakeItems as $intakeItem) {
                            if($key == $intakeItem->language_id){
                                $currentItemId = $intakeItem->id;
                                $currentItemScheduled = $intakeItem->scheduled ? $intakeItem->scheduled->format('d-m-Y') : $intake->online_date->format('d-m-Y');
                                $currentSeats = $intakeItem->seats ? $intakeItem->seats : 100;
                                break;
                            }
                        }
                    ?>
                    <div class="columns">
                        <input type="hidden" name="item_id[]" value="{{ $currentItemId }}">
                        <div class="column is-8">
                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label class="label">{{ $language }} and English</label>
                                </div>
                                <div class="field-body">
                                    <div class="field">
                                        <div class="control">
                                            <input type="text" class="input" name="seats[]" placeholder="How many seats" value="{{ $currentSeats }}">
                                        </div>
                                        <p class="help is-danger">
                                            This field is required if {{ $language }} is available
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <el-form-item label="Schedule Date">
                                <el-date-picker
                                        v-model="scheduled[{{ $key - 1 }}]"
                                        name="scheduled[]"
                                        type="date"
                                        value="{{ $currentItemScheduled }}"
                                        placeholder="Required: Schedule Date">
                                </el-date-picker>
                            </el-form-item>
                        </div>
                    </div>
                @endforeach

                <el-button type="primary" v-on:click="savePage('currentPage')">
                    <i class="el-icon-upload2"></i>&nbsp;Save
                </el-button>
            </el-form>
        </div>
    </div>
@endsection
