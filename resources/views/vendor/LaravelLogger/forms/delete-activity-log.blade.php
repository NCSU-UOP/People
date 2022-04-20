<form method="POST" action="{{route('destroy-activity')}}" accept-charset="UTF-8" class="mb-0">
    @csrf
    @method('DELETE')
    <button type="button" data-bs-toggle="modal" data-bs-target="#confirmDelete" data-title="{!! trans('LaravelLogger::laravel-logger.modals.deleteLog.title') !!}" data-message="{!! trans('LaravelLogger::laravel-logger.modals.deleteLog.message') !!}" class="text-danger dropdown-item">
        <i class="fa fa-fw fa-eraser" aria-hidden="true"></i>
        {!! trans('LaravelLogger::laravel-logger.dashboardCleared.menu.deleteAll') !!}
    </button>
</form>
