@php
if (!isset($actionBtnIcon)) {
  $actionBtnIcon = null;
} else {
  $actionBtnIcon = $actionBtnIcon . ' fa-fw';
}
if (!isset($modalClass)) {
  $modalClass = null;
}
if (!isset($btnSubmitText)) {
  $btnSubmitText = trans('LaravelLogger::laravel-logger.modals.shared.btnConfirm');
}
@endphp

<div class="modal fade modal-{{$modalClass}}" tabindex="-1" id="{{$formTrigger}}" role="dialog" aria-labelledby="{{$formTrigger}}Label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header {{$modalClass}}">
        <h5 class="modal-title">
          Confirm
        </h5>
         <button class="close" data-bs-dismiss="modal" aria-label="Close" aria-hidden="true"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure?</p>
      </div>
      <div class="modal-footer">
        {!! Form::button('<i class="fa fa-fw fa-close" aria-hidden="true"></i> ' . trans('LaravelLogger::laravel-logger.modals.shared.btnCancel'), array('class' => 'btn btn-outline pull-left btn-flat', 'type' => 'button', 'data-bs-dismiss' => 'modal' )) !!}
        {!! Form::button('<i class="fa ' . $actionBtnIcon . '" aria-hidden="true"></i> ' . $btnSubmitText, array('class' => 'btn btn-' . $modalClass . ' pull-right btn-flat', 'type' => 'button', 'id' => 'confirm' )) !!}
      </div>
    </div>
  </div>
</div>
