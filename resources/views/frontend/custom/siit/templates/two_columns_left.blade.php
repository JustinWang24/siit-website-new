@extends(_get_frontend_layout_path('frontend'))
@section('content')
<div class="container">
    @if(!empty($page->feature_image))
    <div class="columns mt-0 pt-0 mb-0 pb-0">
        <div class="column pt-0 pb-0">
            <img src="{{ $page->getFeatureImageUrl() }}" alt="{{ $page->title }}" style="width: 100%;">
        </div>
    </div>
    @else
        <div style="height: 6px;"></div>
    @endif
    <div class="content">
        <div class="columns is-marginless">
            <div class="column is-one-quarter left-side-bar-wrap">
                <?php
                    // 检查一下当前的页面, 如果是2栏的布局，那么试着根据页面的URI, 结合菜单的结构, 自动生成左边可以使用的INDEX
                    $menuItem = $page->getMenuObject();
                    $siblings = $menuItem ? $menuItem->siblings() : [];
                ?>
                @if($menuItem && $menuItem->parent)
                    <h2 class="parent-item"><a href="{{ url($menuItem->parent->link_to) }}" title="{{ $menuItem->parent->name }}">{{ $menuItem->parent->name }}</a></h2>
                    @foreach($siblings as $menuSibling)
                    <h3 class="sibling-item {{ $menuItem->id == $menuSibling->id ? 'current-item' : null }}">
                        <a href="{{ url('/page'.$menuSibling->link_to) }}" title="{{ $menuSibling->name }}">{{ $menuSibling->name }}</a>
                    </h3>
                    @endforeach
                @endif

                <?php
                $blocks = \App\Models\Widget\Block::GetBlocksByType(\App\Models\Widget\Block::$TYPE_LEFT);
                ?>
                @foreach($blocks as $key=>$block)
                    <div class="box" id="left-side-block-{{ $key }}">
                        {!! $block->content !!}
                    </div>
                @endforeach
            </div>
            <div class="column is-three-quarter">
                <div class="thumbnail-wrap">

                </div>
                <div class="page-title-wrap">
                    <h1 class="is-size-1-desktop is-size-1-mobile">{{ $page->title }}</h1>
                </div>
                <div class="content page-content-wrap">
                    {!! $page->rebuildContent() !!}
                </div>
                @if(isset($trainingStaffItems))
                <div class="content">
                    <hr>
                    @foreach($trainingStaffItems as $campusName=>$staffItems)
                        <h2 class="has-text-centered">{{ $campusName }}</h2>
                        <div class="columns is-multiline">
                            @foreach($staffItems as $staffItem)
                            <div class="column is-one-third">
                                <div class="card">
                                    <div class="card-image pt-10">
                                        <figure class="image">
                                            <img src="{{ $staffItem->getAvatarUrl() }}" alt="Avatar: {{ $staffItem->name }}">
                                        </figure>
                                    </div>
                                    <div class="card-content">
                                        <div class="media">
                                            <div class="media-content">
                                                <p class="title is-4">
                                                    <a href="#">{{ $staffItem->name }}</a>
                                                </p>
                                                <p class="subtitle is-5 mt-10">{{ $staffItem->job_title }}</p>
                                            </div>
                                        </div>

                                        <div class="content">
                                            <a href="mailto:{{ $staffItem->email }}"><i class="fas fa-envelope-square"></i>&nbsp;{{ $staffItem->email }}</a>
                                            <br>
                                            <a href="tel:{{ $staffItem->phone }}"><i class="fas fa-phone-square"></i>&nbsp;{{ $staffItem->phone }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection