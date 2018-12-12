<div class="row">
    <div class="form-group col-3">
        <label for="group">Event: <strong>{{ $notification->class }}</strong></label>

        <div class="custom-control custom-checkbox">
            <input type="hidden" name="use_html" value="0">
            <input type="checkbox"
                   class="custom-control-input"
                   name="use_html"
                   value="1"
                   id="use_html"
                    {{ old('use_html', optional($notification)->use_html) == 1 ? 'checked' : null }}
            >
            <label class="custom-control-label"
                   style="width: 100%;"
                   for="use_html"
            >
                Use HTML
            </label>
        </div>

        <div class="custom-control custom-checkbox">
            <input type="hidden" name="active" value="0">
            <input type="checkbox"
                   class="custom-control-input"
                   name="active"
                   value="1"
                   id="active"
                    {{ old('active', optional($notification)->active) == 1 ? 'checked' : null }}
            >
            <label class="custom-control-label"
                   style="width: 100%;"
                   for="active"
            >
                Is Active
            </label>
        </div>
    </div>

    <div class="form-group col-3">
        <label for="channels" class="control-label">Channels</label>
        <select class="form-control"
                multiple="multiple"
                id="channels"
                name="channels[]"
        >
            @foreach(config('oxy_notifications.channels') as $channel)
                <option value="{{ $channel }}"
                        @php $old_and_current = old('channels', json_decode($notification->channels)) @endphp
                        {{ in_array($channel, $old_and_current) ? 'selected' : null }}
                >{{ $channel }}</option>
            @endforeach
        </select>
        <p class="help-block"></p>
    </div>

    <div class="form-group col-6">
        <label for="description">Description<strong></strong></label>
        <textarea class="form-control tinymce{{ $errors->has('description') ? 'is-invalid' : null }}"
               id="description"
               name="description"
               placeholder="Enter notification description..."
        >{{ old('description', optional($notification)->description)}}</textarea>
        {!! $errors->first('description', '<small class="form-text text-danger">:message</small>') !!}
    </div>
</div>

<div class="row">
@foreach(config('oxygen.locales') as $locale => $locale_name)
        <!-- subject -->
        <div class="form-group col-6">
            <label for="{{ "subject-$locale" }}">Subject ({{ $locale }})</label>
            <input type="text"
                   class="form-control {{ $errors->has("subject.$locale") ? 'is-invalid' : null }}"
                   id="{{ "subject-$locale" }}"
                   name="{{ "subject[$locale]" }}"
                   placeholder="Enter notification subject..."
                   value="{{ old("subject.$locale", optional($notification)->getTranslation('subject', $locale)) }}"
            >
            {!! $errors->first("subject.$locale", '<small class="form-text text-danger">:message</small>') !!}
        </div>
@endforeach
    </div>

    {{-- <div class="row">
        <div class="form-group col-6">
            <label for="template">Template<strong></strong></label>
            <input type="text"
                   class="form-control {{ $errors->has('template') ? 'is-invalid' : null }}"
                   id="template"
                   name="template"
                   placeholder="Enter notification template..."
                   value="{{ old('template', optional($notification)->template)}}"/>
            {!! $errors->first('template', '<small class="form-text text-danger">:message</small>') !!}
        </div>

        <div class="form-group col-6">
            <label for="layout">Layout<strong></strong></label>
            <input type="text"
                   class="form-control {{ $errors->has('layout') ? 'is-invalid' : null }}"
                   id="layout"
                   name="layout"
                   placeholder="Enter notification layout..."
                   value="{{ old('layout', optional($notification)->layout)}}"/>
            {!! $errors->first('layout', '<small class="form-text text-danger">:message</small>') !!}
        </div>
    </div>--}}

    <br/>
    <h3>Fields</h3>

    <div id="fields">
        <div id="field-blank" style="display: none">
             <div class="row" style="display: none">
                <div class="form-group col-6">
                    <label for="field_name[]">Name<strong></strong></label>
                    <input type="text"
                           class="form-control"
                           id="field_name[]"
                           name="field_name[]"
                           placeholder="Enter field name..."
                           value=""/>
                </div>
                <div class="form-group col-6">
                    <label for="field_placeholders[]">Placeholders<strong></strong></label>
                    <input type="text"
                           class="form-control"
                           id="field_placeholders[]"
                           name="field_placeholders[]"
                           placeholder="Enter placeholders..."
                           value=""/>
                </div>
            </div>
            <div class="row">
            @foreach(config('oxygen.locales') as $locale => $locale_name)
                <div class="form-group col-6">
                    <label for="{{ "field_value-$locale" }}[]">Value ({{ $locale }})</label>
                    <textarea
                           class="form-control"
                           id="{{ "field_value-$locale" }}[]"
                           name="{{ "field_value-$locale" }}[]"
                           placeholder="Enter notification field value..."
                    ></textarea>
                </div>
            @endforeach
            </div>
        </div>


    @foreach ($notification->fields as $f => $field)
        <div id="field-{{ $f }}" class="row-field">
            <div class="row" style="display: none">
                <div class="form-group col-6">
                    <label for="field_name[]">Name<strong></strong></label>
                    <input type="text"
                           class="form-control"
                           id="field_name[]"
                           name="field_name[]"
                           placeholder="Enter field name..."
                           value="{{ $field->name }}"/>
                </div>
                <div class="form-group col-6">
                    <label for="field_placeholders[]">Placeholders<strong></strong></label>
                    <input type="text"
                           class="form-control"
                           id="field_placeholders[]"
                           name="field_placeholders[]"
                           placeholder="Enter placeholders..."
                           value="{{ json_decode($field->field_placeholders) }}"/>
                </div>
            </div>
            <div class="row field-{{ $f }}">
            @foreach(config('oxygen.locales') as $locale => $locale_name)
                <div class="form-group col-6">
                    <label for="{{ "field_value-$locale" }}[]">Value ({{ $locale }})</label>
                    <textarea
                           class="form-control"
                           id="{{ "field_value-$locale" }}[]"
                           name="{{ "field_value-$locale" }}[]"
                           placeholder="Enter notification field value..."
                    >{{ old("field_value.$locale", optional($field)->getTranslation('value', $locale)) }}</textarea>
                    {!! $errors->first("field_value.$locale", '<small class="form-text text-danger">:message</small>') !!}
                </div>
            @endforeach
            </div>
            <button class="btn btn-danger" type="button" onclick="removeField({{ $f }})">Remove Field</button>
            <hr>
        </div>
    @endforeach



    </div>

    <button class="btn btn-success" type="button" onclick="addField()">Add Field</button>
    <br/>
    <br/>
    <hr>


<script type="text/javascript">
    function removeField(id) {
        $('#field-'+id).remove();
    }

    function addField() {
        var id = $('.row-field').length;
        $('#fields').append('<div id="field-'+id+'" class="row-field">'+$('#field-blank').html()+'<button class="btn btn-danger" type="button" onclick="removeField('+id+')">Remove Field</button><hr/></div>');
    }

</script>

