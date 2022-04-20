<form method="POST" action="{{route('clear-activity')}}" accept-charset="UTF-8">
    @csrf
    @method('DELETE')
    <button type="button" data-bs-toggle="modal" data-bs-target="#confirmDelete" data-title="{!! trans('LaravelLogger::laravel-logger.modals.clearLog.title') !!}" data-message="{!! trans('LaravelLogger::laravel-logger.modals.clearLog.message') !!}" class="dropdown-item">
        <i class="fa fa-fw fa-trash" aria-hidden="true"></i>
        {!! trans('LaravelLogger::laravel-logger.dashboard.menu.clear') !!}
    </button>
</form>