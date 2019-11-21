@set('adBanners', $banner_helper->getBannersNotInType(['banner-slider','single-col-block']))
@foreach($adBanners as $adBanner)
    @include(Site::templateResolver("core::website.banners.partials.{$adBanner->template}"))
@endforeach