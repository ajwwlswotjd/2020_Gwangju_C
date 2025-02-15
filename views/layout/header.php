<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap-4.4.1-dist/css/bootstrap.css">
    <link rel="stylesheet" href="css/fontawesome/css/font-awesome.css">
    <script src="js/jquery-3.5.0.min.js"></script>
    <script src="js/jquery-ui-1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="js/jquery-ui-1.12.1/jquery-ui.css">
    <script src="js/common.js"></script>
    <title>광주 C</title>
</head>

<body>

    <div id="way_modal" title="찾아오시는 길">

    </div>

    <!-- 헤더 시작 -->

    <header>
        <div class="header-util">
            <div class="container-1140 d-flex justify-content-between align-items-center">

                <div class="util-search color-666">
                    <i class="fa fa-search"></i>
                    <input type="text" placeholder="검색" class="ml-1 all-unset">
                </div>

                <div class="util-right d-flex align-items-center">
                    <select class="all-unset color-666-hover">
                        <option selected value="ko">한국어</option>
                        <option value="en">English</option>
                        <option value="ch">中文(简体)</option>
                    </select>
                    <i class="fa fa-chevron-down color-666" style="font-size: 12px;"></i>
                    <div class="util-nav ml-2">
                        <a href="#" class="ml-2 color-666-hover">전라북도청</a>
                        <?php if(__SIGN) : ?>
                            <a href="/user_logout" class="ml-2 color-666-hover">로그아웃</a>
                        <?php else : ?>
                        <a href="/user_login" class="ml-2 color-666-hover">로그인</a>
                        <a href="/user_join" class="ml-2 color-666-hover">회원가입</a>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>

        <div class="header-bottom">
            <div class="container-1140 d-flex justify-content-between align-items-center">


                <img src="imgs/logo.jpg" alt="img" title="img" id="logo">
                <nav class="d-flex align-items-center">
                    <a class="ml-3 color-666-hover align-items-center d-flex" href="/">HOME</a>
                    <a class="ml-3 color-666-hover align-items-center d-flex" href="/festival">전북 대표 축제</a>
                    <a class="ml-3 color-666-hover align-items-center d-flex" href="#">축제 정보</a>
                    <a class="ml-3 color-666-hover align-items-center d-flex" href="#">축제 일정</a>
                    <a class="ml-3 color-666-hover align-items-center d-flex" href="/exchangeRate">환율안내</a>
                    <a id="hover-to-2depth" class="ml-3 color-666-hover align-items-center d-flex" href="#">
                        종합지원센터
                    </a>
                    <div id="dep2">
                        <a href="/notice" class="color-666-hover">공지사항</a>
                        <a href="#" class="color-666-hover">센터 소개</a>
                        <a href="#" class="color-666-hover">관광정보 문의</a>
                        <a href="#" class="color-666-hover">데이터 공개</a>
                        <a href="#" class="color-666-hover" id="find_way">찾아오시는 길</a>
                    </div>
                </nav>

            </div>
        </div>
    </header>

    <!-- 헤더 끝 -->