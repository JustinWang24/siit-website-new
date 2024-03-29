@extends(_get_frontend_layout_path('frontend'))
@section('content')
<div class="container mt-10 mb-10">

    <div class="content">
        <div class="columns is-marginless">
            @if($agentObject->isDesktop())
            <div class="column is-one-fifth left-side-bar-wrap">
                <?php
                    // 检查一下当前的页面, 如果是2栏的布局，那么试着根据页面的URI, 结合菜单的结构, 自动生成左边可以使用的INDEX
                    $menuItem = $page->getMenuObject();
                    $siblings = $menuItem ? $menuItem->siblings() : [];
                ?>
                @if($menuItem && $menuItem->parent)
                    <h2 class="parent-item">
                        <a href="{{ url($menuItem->parent->link_to) }}" title="{{ app()->getLocale()=='cn'?$menuItem->parent->name_cn:$menuItem->parent->name  }}" style="font-weight: normal;">
                            {{ app()->getLocale()=='cn'?$menuItem->parent->name_cn:$menuItem->parent->name }}
                        </a>
                    </h2>
                    @foreach($siblings as $menuSibling)
                        <?php
                            $urlLink = '/page'.$menuSibling->link_to;
                            if($menuSibling->link_type == \App\Models\Utils\ContentTool::$CONTENT_TYPE_DYNAMIC){
                                $urlLink = $menuSibling->link_to;
                            }
                        ?>
                    <h3 class="sibling-item {{ $menuItem->id == $menuSibling->id ? 'current-item' : null }}">
                        <a href="{{ url($urlLink) }}" title="{{ app()->getLocale()=='cn'? $menuSibling->name_cn : $menuSibling->name }}" style="font-weight: normal;">
                            {{ app()->getLocale()=='cn'? $menuSibling->name_cn : $menuSibling->name }}
                        </a>
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
            @endif
            <div class="column is-four-fifths">
                @if(!empty($page->feature_image))
                    <img src="{{ $page->getFeatureImageUrl() }}" alt="{{ $page->title }}" style="width: 100%;">
                @else
                    <div style="height: 6px;"></div>
                @endif
                <div class="thumbnail-wrap">

                </div>
                <div class="page-title-wrap">
                    <h1 style="font-size: 36px;font-weight: bold;font-family: Roboto Condensed, SimHei;">{{ app()->getLocale()=='cn'?$page->title_cn:$page->title }}</h1>
                </div>
                <div class="content page-content-wrap">
                    {!! $page->rebuildContent() !!}
                </div>
            @if(isset($trainingStaffItems))
                <?php
                    $currentJobGroup = null;
                ?>
                <div class="content pl-20">
                    <hr>
                    @foreach($trainingStaffItems as $campusName=>$staffItems)
                        <h2 class="has-text-centered">{{ $campusName }}</h2>
                        <div class="content">
                            @foreach($staffItems as $staffItem)
                                @if($currentJobGroup != $staffItem->job_group)
                                    <?php
                                    $currentJobGroup = $staffItem->job_group;
                                    ?>
                                    <div class="column is-12"><h3>{{ \App\Models\Staff::GetJobGroupName($currentJobGroup) }}</h3></div>
                                @endif

                                <div class="box">
                                    <article class="media">
                                        <div class="media-left">
                                            <a href="{{ url( '/staff-profile?name='.$staffItem->name ) }}" title="{{ $staffItem->name }}">
                                            <figure>
                                                <img src="{{ $staffItem->getAvatarUrl() }}" alt="Avatar: {{ $staffItem->name }}" style="height: 130px;">
                                            </figure>
                                            </a>
                                        </div>
                                        <div class="media-content">
                                            <div class="content">
                                                <p>
                                                    <strong>
                                                        <a href="{{ url( '/staff-profile?name='.$staffItem->name ) }}" title="{{ $staffItem->name }}">{{ $staffItem->name }}</a>
                                                    </strong>
                                                    <a href="mailto:{{ $staffItem->email }}">&nbsp;<i class="fas fa-envelope-square"></i>&nbsp;{{ $staffItem->email }}</a>
                                                    <a href="tel:{{ $staffItem->phone }}">&nbsp;<i class="fas fa-phone-square"></i>&nbsp;{{ $staffItem->phone }}</a>
                                                </p>
                                                <p>{{ $staffItem->job_title }}</p>
                                            </div>
                                        </div>
                                    </article>
                                </div>

                            @endforeach
                        </div>
                    @endforeach
                </div>
            @endif

            @if(isset($StaffMembers))
                <?php
                $currentDivision = null;
                ?>
                <div class="content pl-20">
                    <hr>
                    @foreach($StaffMembers as $staffItem)
                        @if($currentDivision != $staffItem->division)
                            <?php
                            $currentDivision = $staffItem->division;
                            ?>
                    <div class="column is-12"><h2>{{ \App\Models\Staff::GetDivisionName($currentDivision) }}</h2></div>
                        @endif
                    <div class="box">
                        <article class="media">
                            <div class="media-left">
                                <a href="{{ url( '/staff-profile?name='.$staffItem->name ) }}" title="{{ $staffItem->name }}">
                                    <figure>
                                        <img src="{{ $staffItem->getAvatarUrl() }}" alt="Avatar: {{ $staffItem->name }}" style="height: 130px;">
                                    </figure>
                                </a>
                            </div>
                            <div class="media-content">
                                <div class="content">
                                    <p>
                                        <strong>
                                            <a href="{{ url( '/staff-profile?name='.$staffItem->name ) }}" title="{{ $staffItem->name }}">{{ $staffItem->name }}</a>
                                        </strong>
                                        <a href="mailto:{{ $staffItem->email }}">&nbsp;<i class="fas fa-envelope-square"></i>&nbsp;{{ $staffItem->email }}</a>
                                        <a href="tel:{{ $staffItem->phone }}">&nbsp;<i class="fas fa-phone-square"></i>&nbsp;{{ $staffItem->phone }}</a>
                                    </p>
                                    <p>{{ $staffItem->job_title }}</p>
                                </div>
                            </div>
                        </article>
                    </div>
                    @endforeach
                </div>
            @endif
            </div>
        </div>
    </div>
</div>
@endsection