 <nav class="navbar navbar-expand-lg navbar-light">
    <a href="#"><img src="assets/website/images/Logo.jpg" alt="logo"></a>
    <a href="#" data-target="mobile-demo" class="mobile-menu-btn"><i class="fa fa-bars"></i></a>
    <ul id="mobile-demo" class="dropdown-content">
        <li><a class="nav-link" href="{{route('website.home')}}">Home</a></li>
        <li><a class="nav-link" href="#">Areas</a></li>
        <li><a class="nav-link" href="{{route('website.realestate.homes-for-sale')}}">Homes For Sale</a></li>
        <li><a class="nav-link" href="{{route('website.realestate.sold-homes')}}">Sold Homes</a></li>
        <li><a class="nav-link" href="{{route('website.realestate.market.reports', ['type' => 'cities'])}}">Market Stats</a></li>
        <li><a class="nav-link" href="#">Login</a></li>
        <li><a class="nav-link" href="#">Register</a></li>
    </ul>
    <ul class="right hide-on-med-and-down">
        <li><a class="nav-link" href="{{route('website.home')}}">Home</a></li>
        <li><a class="nav-link" href="#">Areas</a></li>
        <li><a class="nav-link" href="{{route('website.realestate.homes-for-sale')}}">Homes For Sale</a></li>
        <li><a class="nav-link" href="{{route('website.realestate.sold-homes')}}">Sold Homes</a></li>
        <li><a class="nav-link" href="{{route('website.realestate.market.reports', ['type' => 'cities'])}}">Market Stats</a></li>
        <li class="nav-btn">
            @if(Auth::check())
                 <a class="nav-link waves-effect waves-light modal-trigger" href="{{route('website.realestate.profile.index')}}">My Review</a>
            @else
                <a class="nav-link waves-effect waves-light modal-trigger" href="#loginmodal">Login</a>
            @endif
            <div id="loginmodal" class="modal">
                <form action="{{route('website.realestate.leads.login')}}" method="post">
                    @csrf
                    <div class="row modal-header">
                        <button type="button" class="modal-close"> <span>×</span> </button>
                        <h4 class="modal-title">Login</h4>
                    </div>
                    <div class="modal-content">
                        <p class="center-align">To access Advanced MLS Information, login below</p>
                        <div class="form-group row">
                            <input id="email" type="email" class="form-control" name="email" value="" placeholder="E-Mail Address" required="">
                        </div>
                        <div class="form-group row">
                            <input type="password" class="form-control" name="password" value="" placeholder="Password" required="">
                        </div>
                        <div class="form-group row">
                            <input type="checkbox">
                            Remember Me
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="" type="text" class="btn btn-default pull-left load-register-form"> Not yet registered ? Register here </a>
                        <a href="https://scottingraham.com/user/password/reset" class="pull-left btn btn-default"> Password recovery </a>
                        <button type="submit" class="btn btn-primary"> <div class="loader-01"></div> Login </button>
                    </div>
                </form>
            </div>
        </li>
        <li class="nav-btn">
            @if(Auth::check())
                <a class="nav-link waves-effect waves-light modal-trigger" href="{{route('website.realestate.leads.logout')}}">Logout</a>
            @else
                <a class="nav-link waves-effect waves-light modal-trigger" href="#registermodal">Register</a>
            @endif
                <div id="registermodal" class="modal">
                    <form method="post" action="{{route('website.realestate.leads.register')}}">
                        @csrf
                        <div class="row modal-header">
                            <button type="button" class="modal-close"> <span>×</span> </button>
                            <h4 class="modal-title">To Continue..</h4>
                        </div>
                        <div class="modal-content">
                            <p class="center-align">To access Advanced MLS Information, you must enter your info below</p>
                            <div class="form-group row">
                                <input type="text" name="firstname" class="form-control" value="" placeholder="First Name" required="">
                            </div>
                            <div class="form-group row">
                                <input type="text"  name="lastname" class="form-control" value="" placeholder="Last Name" required="">
                            </div>
                            <div class="form-group row">
                                <input type="email" name="email" class="form-control" value="" placeholder="Email" required="">
                            </div>
                            <div class="form-group row">
                                <input type="password" name="password" class="form-control" value="" placeholder="Password" required="">
                            </div>
                            <p class="agree-to-terms">By registering on our site you agree to the website terms.We protect your personal privacy and email security. View our <a href="">privacy policy</a>
                            </p>
                        </div>
                        <div class="modal-footer">
                            <a href="" type="text" class="btn btn-default pull-left load-register-form"> Already a member ? Login </a>

                            <button type="submit" class="btn btn-primary"> <div class="loader-01"></div> Register </button>
                        </div>
                    </form>
                </div>
        </li>
    </ul>
</nav>
