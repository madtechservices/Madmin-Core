@if (config('backpack.base.breadcrumbs') && isset($breadcrumbs) && is_array($breadcrumbs) && count($breadcrumbs))
	<nav aria-label="breadcrumb" class="d-none d-lg-block">
	  <ol class="breadcrumb">
	  	@foreach ($breadcrumbs as $label => $link)
	  		@if ($link)
			    <li class="breadcrumb-item text-capitalize"><a href="{{ $link }}">{{ $label }}</a></li>
	  		@else
			    <li class="breadcrumb-item active text-capitalize" aria-current="page">{{ $label }}</li>
	  		@endif
	  	@endforeach

		@if (isset($breadcrumbs_menu) && count($breadcrumbs_menu) > 0)
			<li class="breadcrumb-menu d-md-down-none">
				<div class="btn-group" role="group" aria-label="Button group">
					@foreach ($breadcrumbs_menu as $item)
						{{ $item->render() }}
					@endforeach
				</div>
			</li>
		@endif
	  </ol>
	</nav>
@endif