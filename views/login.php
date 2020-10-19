<div class="container mt-5 mb-5">
    
    <h1>로그인</h1>

    <form action="/user/login" method="POST" class="mt-5">
        <label for="id">아이디</label>
        <input type="text" class="form-control mb-3" id="id" name="id">
        <label for="password">비밀번호</label>
        <input type="password" class="form-control" id="password" name="password">
        <button type="submit" class="btn btn-primary mt-3">로그인</button>
        <button type="button" class="btn btn-info mt-3">회원가입</button>
    </form>
    <div class="row mt-3 d-flex align-items-center">
        <div class="col-6">
            <input type="checkbox" id="loginCheckbox">
            <label for="loginCheckbox">Remember me</label>
        </div>
        <a href="#" class="col-6">Forgot Password</a>
    </div>


</div>