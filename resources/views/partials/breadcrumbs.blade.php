 {{-- resources/views/partials/breadcrumbs.blade.php --}}

 @unless ($breadcrumbs->isEmpty())
     <!-- Start Breadcrumbs -->
     <div class="breadcrumbs">
         <div class="container">
             <div class="row align-items-center">
                 <div class="col-lg-6 col-md-6 col-12">
                     <div class="breadcrumbs-content">
                         <h1 class="page-title">@yield('title')</h1>
                     </div>
                 </div>
                 <div class="col-lg-6 col-md-6 col-12">
                     <ul class="breadcrumb-nav">
                         @foreach ($breadcrumbs as $breadcrumb)
                             @if (!is_null($breadcrumb->url) && !$loop->last)
                                 <li><a href="{{ $breadcrumb->url }}">
                                         @if ($loop->first)
                                             <i class="lni lni-home"></i>
                                         @endif {{ $breadcrumb->title }}
                                     </a></li>
                             @else
                                 <li>{{ $breadcrumb->title }}</li>
                             @endif
                         @endforeach
                     </ul>
                 </div>
             </div>
         </div>
     </div>
     <!-- End Breadcrumbs -->
 @endunless
