@extends('layouts.home')

@section('title', $head['title'])

@section('keywords', $head['keywords'])

@section('description', $head['description'])

@section('bgimg')
<img src="{{ asset('images/home/banner1.jpg') }}" width="100%" />
@endsection

@section('content')
    <!-- 左侧列表开始 -->
    <div class="col-xs-12 col-md-12 col-lg-9">
        @if(!empty($tagName))
            <div class="row b-tag-title">
                <div class="col-xs-12 col-md-12 col-lg-12">
                    <h2>拥有<span class="b-highlight">{{ $tagName }}</span>标签的文章</h2>
                </div>
            </div>
        @endif
        @if(request()->has('wd'))
            <div class="row b-tag-title">
                <div class="col-xs-12 col-md-12 col-lg-12">
                    <h2>搜索到的与<span class="b-highlight">{{ clean(request()->input('wd')) }}</span>相关的文章</h2>
                </div>
            </div>
        @endif
    <!-- 循环文章列表开始 -->
        @foreach($article as $k => $v)
            <div class="row b-one-article">
                <h3 class="col-xs-12 col-md-12 col-lg-12">
                    <a class="b-oa-title" href="{{ url('article', [$v->id]) }}" target="_blank">{{ $v->title }}</a>
                </h3>
                <div class="col-xs-12 col-md-12 col-lg-12 b-date">
                    <ul class="row">
                        <li class="col-xs-5 col-md-2 col-lg-3">
                            <i class="fa fa-user"></i> {{ $v->author }}
                        </li>
                        <li class="col-xs-7 col-md-3 col-lg-3">
                            <i class="fa fa-calendar"></i> {{ $v->created_at }}
                        </li>
                        <li class="col-xs-5 col-md-2 col-lg-3">
                            <i class="fa fa-list-alt"></i> <a href="{{ url('category', [$v->category->id]) }}"
                                                              target="_blank">{{ $v->category->name }}</a>
                        </li>
                        <li class="col-xs-7 col-md-5 col-lg-3 "><i class="fa fa-tags"></i>
                            @foreach($v->tags as $n)
                                <a class="b-tag-name" href="{{ url('tag', [$n->id]) }}"
                                   target="_blank">{{ $n->name }}</a>
                            @endforeach
                        </li>
                    </ul>
                </div>
                <div class="col-xs-12 col-md-12 col-lg-12">
                    <div class="row">
                        <!-- 文章封面图片开始 -->
                        <div class="col-sm-5 col-md-4 col-lg-4 hidden-xs">
                            <figure class="b-oa-pic b-style1">
                                <a href="{{ url('article', $v->id) }}" target="_blank">
                                    <img src="{{ asset($v->cover) }}" alt="{{ config('hzfblog.alt_word') }}"
                                         title="{{ config('hzfblog.alt_word') }}">
                                </a>
                                <figcaption>
                                    <a href="{{ url('article', [$v->id]) }}" target="_blank"></a>
                                </figcaption>
                            </figure>
                        </div>
                        <!-- 文章封面图片结束 -->

                        <!-- 文章描述开始 -->
                        <div class="col-xs-12 col-sm-7  col-md-8 col-lg-8 b-article-desc">
                            {{ $v->description }}
                        </div>
                        <!-- 文章描述结束 -->
                        <div class="col-xs-12 col-sm-7  col-md-8 col-lg-8">
                            <i class="fa fa-eye" aria-hidden="true"></i>&nbsp;阅读数&nbsp;&nbsp;{{ $v->click }}
                        </div>
                    </div>
                </div>
                <a class="b-readall" href="{{ url('article', [$v->id]) }}" target="_blank">阅读全文</a>
            </div>
    @endforeach
    <!-- 循环文章列表结束 -->

        <!-- 列表分页开始 -->
        <div class="row">
            <div class="col-xs-12 col-md-12 col-lg-12 b-page text-center">
                {{ $article->appends(['wd' => request()->input('wd')])->links('vendor.pagination.bjypage') }}
            </div>
        </div>
        <!-- 列表分页结束 -->
    </div>
    <!-- 左侧列表结束 -->
@endsection
