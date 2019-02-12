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
            {!! $errors->first('channels', '<small class="form-text text-danger">:message</small>') !!}
        <p class="help-block"></p>
    </div>

    <div class="form-group col-6">
        <label for="description">Description<strong></strong></label>
        <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : null }}"
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
            <label for="{{ "subject-$locale" }}">Subject ({{ strtoupper($locale) }})</label>
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

<div class="row">
@foreach(config('oxygen.locales') as $locale => $locale_name)
        <!-- subject -->
        <div class="form-group col-6">
            <label for="{{ "button_title-$locale" }}">Button Title ({{ strtoupper($locale) }})</label>
            <input type="text"
                   class="form-control {{ $errors->has("button_title.$locale") ? 'is-invalid' : null }}"
                   id="{{ "button_title-$locale" }}"
                   name="{{ "button_title[$locale]" }}"
                   placeholder="Enter notification button_title..."
                   value="{{ old("button_title.$locale", optional($notification)->getTranslation('button_title', $locale)) }}"
            >
            {!! $errors->first("button_title.$locale", '<small class="form-text text-danger">:message</small>') !!}
        </div>
@endforeach
</div>

    <br/>
    <h3>Fields</h3>

    <div id="fields">
        <div id="field-blank" style="display: none">
            <input type="hidden"
                     class="form-control"
                     id="field_is_button[]"
                     name="field_is_button[]"
                     value="0"/>
            <div class="row">
            @foreach(config('oxygen.locales') as $locale => $locale_name)
                <div class="form-group col-6">
                    <label for="{{ "field_value-$locale" }}[]">Content ({{ strtoupper($locale) }})</label>
                    <textarea
                            data-locale="{{ $locale }}"
                           class="form-control"
                           id="{{ "field_value-$locale" }}[]"
                           name="{{ "field_value-$locale" }}[]"
                           placeholder="Enter notification field value..."
                    ></textarea>
                </div>
            @endforeach
            </div>
        </div>
        <div id="button-blank" style="display: none">
          <div class="row row-button">
            <input type="hidden"
                     class="form-control"
                     id="field_is_button[]"
                     name="field_is_button[]"
                     value="1"/>
            @foreach(config('oxygen.locales') as $locale => $locale_name)
                    <input
                          type="hidden"
                           id="{{ "field_value-$locale" }}[]"
                           name="{{ "field_value-$locale" }}[]"
                           value=""
                    >
            @endforeach
            <div class="form-group col-12">
              <label>
                Use this as a placeholder to specify the exact vertical slot where the CTA button should appear
                <br/>
                *Button title will still be taken from the Button title field
              </label>
            </div>
          </div>
        </div>

    @php $hide_button = 0 @endphp
    @foreach ($notification->fields as $f => $field)
        <div id="field-{{ $f }}" class="row-field">
            <input type="hidden"
                     class="form-control"
                     id="field_is_button[]"
                     name="field_is_button[]"
                     value="{{ $field->is_button }}"/>
      @if ($field->is_button)
          @php $hide_button = 1 @endphp
          <div class="row row-button row-field">
            <div class="form-group col-12">
              <label>
                Use this as a placeholder to specify the exact vertical slot where the CTA button should appear
                <br/>
                *Button title will still be taken from the Button title field
              </label>
            </div>
          </div>
          <button class="btn btn-danger" type="button" onclick="removeField({{ $f }})">Remove button</button>
      @else
          <div class="row field-{{ $f }}">
            @foreach(config('oxygen.locales') as $locale => $locale_name)
              <div class="form-group col-6">
                  <label for="{{ "field_value-$locale" }}[]">Content ({{ strtoupper($locale) }})</label>
                  <textarea
                         class="form-control tinymce"
                         id="{{ "field_value-$locale" }}[]"
                         name="{{ "field_value-$locale" }}[]"
                         placeholder="Enter notification field value..."
                  >{{ old("field_value.$locale", optional($field)->getTranslation('value', $locale)) }}</textarea>
                  {!! $errors->first("field_value.$locale", '<small class="form-text text-danger">:message</small>') !!}
              </div>
            @endforeach
          </div>
          <button class="btn btn-danger" type="button" onclick="removeField({{ $f }})">Remove Field</button>
      @endif
            <hr>
        </div>
    @endforeach
    </div>

    <button class="btn btn-success" type="button" onclick="addField()">Add Field</button>
    <button class="btn btn-success" type="button" onclick="addButton()" id="add-button"@if ($hide_button)  style="display:none" @endif>Add Button</button>
    <br/>
    <br/>
    <hr>

@push('js')
  <script type="text/javascript">
      function removeField(id)
      {
          $('#field-'+id).remove();
          checkAddButtonVisibility();
      }

      function addField()
      {
        var id = $('.row-field').length;

        $('#fields').append('<div id="field-'+id+'" class="row-field">'+$('#field-blank').html()+'<button class="btn btn-danger" type="button" onclick="removeField('+id+')">Remove Field</button><hr/></div>');
        
        $('#field-'+id+' textarea').each(function(){

          var textarea_id = 'field-'+id+'-'+$(this).attr('data-locale');

          $(this).attr('id', textarea_id);

          tinymce.init({
              selector: '#'+textarea_id,
              plugins: ['code', 'link', 'image'],
              relative_urls : false,
              remove_script_host : true,
              image_advtab: true,
              image_dimensions: false,
              image_class_list: [
                  {title: 'None', value: ''},
                  {title: 'Responsive', value: 'img-responsive'}
              ]
          });

        });

        checkAddButtonVisibility();
      }

      function addButton()
      {
          var id = $('.row-field').length;
          $('#fields').append('<div id="field-'+id+'" class="row-button">'+$('#button-blank').html()+'<button class="btn btn-danger" type="button" onclick="removeField('+id+')">Remove Button</button><hr/></div>');
          checkAddButtonVisibility();
      }

      function checkAddButtonVisibility()
      {
        if ($('.row-button').length > 1) {
          $('#add-button').hide();
        } else {
          $('#add-button').show();
        }
      }

      function deleteBlankFields()
      {
        $('.js-delete-before-submit').remove();
      }

  </script>
@endpush

@include('oxygencms::admin.partials.tinymce', ['selector' => '.tinymce', 'model' => $notification])
