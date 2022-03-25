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

<div class="modal" id="{{$formTrigger}}" tabindex="-1" aria-hidden="true" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          Confirm
        </h5>
         <button class="close" data-bs-dismiss="modal" aria-label="Close" aria-hidden="true"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure?</p>
      </div>
      <div class="modal-footer">
        <!-- <button data-bs-dismiss = 'modal' class = 'btn btn-outline pull-left btn-flat'>
        Cancel
        </button> -->
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button class = 'btn btn-{{$modalClass}} pull-right btn-flat' id = 'confirm' data-bs-target="{{route('clear-activity')}}" data-bs-method="get">
        <i class="fa ' . {{$actionBtnIcon}} . '" aria-hidden="true"></i>
        {{$btnSubmitText}}
        </button>
      </div>
    </div>
  </div>
</div>
