<!-- {!! Form::open(array('route' => 'clear-activity')) !!}
    {!! Form::hidden('_method', 'DELETE') !!}
    {!! Form::button('<i class="fa fa-fw fa-trash" aria-hidden="true"></i>' . trans('LaravelLogger::laravel-logger.dashboard.menu.clear'), array('type' => 'button', 'data-bs-toggle' => 'modal', 'data-bs-target' => '#confirmDelete', 'data-bs-title' => trans('LaravelLogger::laravel-logger.modals.clearLog.title'),'data-bs-message' => trans('LaravelLogger::laravel-logger.modals.clearLog.message'), 'class' => 'dropdown-item')) !!}
{!! Form::close() !!} -->


<a type = 'button' data-bs-toggle = 'modal' data-bs-target = '#confirmDelete' data-bs-title = "{!! trans('LaravelLogger::laravel-logger.modals.clearLog.title') !!}" data-bs-message = "{!! trans('LaravelLogger::laravel-logger.modals.clearLog.message') !!}" class = 'dropdown-item'>
    <i class="fa fa-fw fa-trash" aria-hidden="true"></i>
    {!! trans('LaravelLogger::laravel-logger.dashboard.menu.clear') !!}
</a>