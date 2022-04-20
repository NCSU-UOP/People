<form method="POST" action="{{route('restore-activity')}}" accept-charset="UTF-8" class="mb-0">
    @csrf
    @method('POST')
    <button type="button" data-bs-toggle="modal" data-bs-target="#confirmRestore" data-title="{!! trans('LaravelLogger::laravel-logger.modals.restoreLog.title') !!}" data-message="{!! trans('LaravelLogger::laravel-logger.modals.restoreLog.message') !!}" class="text-success dropdown-item">
        <i class="fa fa-fw fa-history" aria-hidden="true"></i>
        {!! trans('LaravelLogger::laravel-logger.dashboardCleared.menu.restoreAll') !!}
    </button>
</form>