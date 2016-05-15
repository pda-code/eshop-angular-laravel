<!doctype html>
<html ng-app="App" ng-controller="appController">
<head>

  <meta charset="utf-8">
  <!--[if IE]>
  <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1"><![endif]-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Codetrim - Laravel 5</title>
  <meta name="description" content="{{ ui.metaDescription }}">
  <meta name="keywords" content="{{ ui.metaKeywords }}">

  <link media="all" type="text/css" rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link media="all" type="text/css" rel="stylesheet" href="bower_components/font-awesome-4.2.0/css/font-awesome.min.css">
  <link media="all" type="text/css" rel="stylesheet" href="bower_components/angular-loading-bar/build/loading-bar.css"/>
  <link media="all" type="text/css" rel="stylesheet" href="bower_components/yamm3/yamm/yamm.css"/>
  <link media="all" type="text/css" rel="stylesheet" href="bower_components/angular-bootstrap-lightbox/dist/angular-bootstrap-lightbox.css"/>

  <!-- Google Web Fonts
  <link href="http://fonts.googleapis.com/css?family=Roboto+Condensed:300italic,400italic,700italic,400,300,700" rel="stylesheet" type="text/css">
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
  -->

  <!-- CSS Files -->
  <link href="css/style.css" rel="stylesheet">
  <link href="css/responsive.css" rel="stylesheet">


  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Fav and touch icons
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/fav-144.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/fav-114.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/fav-72.png">
  <link rel="apple-touch-icon-precomposed" href="images/fav-57.png">
  <link rel="shortcut icon" href="images/fav.png">
  -->
</head>

<body>

<header id="header-area">
  <div class="header-top">
    <div class="container">
      <!-- Header Links Starts -->
      <div class="col-sm-12 col-xs-12 header-links">
        <ul class="nav navbar-nav pull-left">
          <li>
            <a ui-sref="home"><i class="fa fa-home" title="Home"></i><span class="hidden-sm hidden-xs" translate="{{'HOME'}}"></span></a>
          </li>
          <li>
            <a ui-sref="wishlist"><i class="fa fa-heart" title="Wish List"></i><span class="hidden-sm hidden-xs" translate="{{'WISHLIST_CART'}}"></span>
              <span class="badge badge-warning badge-notification">{{app.wishlist.items.length}}</span></a>
          </li>
          <li>
            <a ui-sref="compare"><i class="fa fa-bar-chart-o" title="compare Cart"></i><span class="hidden-sm hidden-xs" translate="{{'COMPARE_CART'}}"></span>
              <span class="badge badge-warning badge-notification">{{app.comparison.items.length}}</span></span>
            </a>
          </li>
          <li>
            <a ui-sref="checkout">
              <i class="fa fa-crosshairs" title="Checkout"></i><span class="hidden-sm hidden-xs">Checkout</span></a>
          </li>
          <li>
            <a href ng-click="flush()"> <i class="fa fa-lock" title="Login"></i><span class="hidden-sm hidden-xs">flush Session</span></a>
          </li>

        </ul>

        <ul class="nav navbar-nav pull-right">
          <li dropdown>
            <a href class="dropdown-toggle" ngCloak> {{app.currency.symbol}} -
              {{app.currency.title}} <i class="fa fa-caret-down"></i> </a>
            <ul class="pull-right dropdown-menu" role="menu">
              <li ng-repeat="item in app.currencies">
                <a href ng-click="app.setCurrency(item)">{{item.symbol}} -
                  {{item.title}}</a>
              </li>
            </ul>
          </li>


          <li dropdown>
            <a href class="dropdown-toggle" ngCloak>
              <img ng-src="images/flags/{{app.language.image}}"/>
              {{app.language.name}} <i class="fa fa-caret-down"></i> </a>
            <ul class="pull-right dropdown-menu" role="menu">
              <li ng-repeat="item in app.languages">
                <a href ng-click="app.setLanguage(item)"><img ng-src="images/flags/{{item.image}}"/>{{item.name}}</a>
              </li>
            </ul>
          </li>

          <li ng-if="app.isAuthenticated()" dropdown>
            <a href class="dropdown-toggle">
              <i class="fa fa-user" title="Login"></i><span class="hidden-sm hidden-xs">{{app.customer.first_name}} {{app.customer.last_name}}</span>
              <i class="fa fa-caret-down"></i> </a>
            <ul class="dropdown-menu" role="menu">
              <li>
                <a ui-sref="account" ng-click="">My Account</a>
                <a href ng-click="app.logout()">Logout</a>
              </li>
            </ul>
          </li>
          <li ng-if="!app.isAuthenticated()">
            <a ui-sref="login">
              <i class="fa fa-lock" title="Login"></i><span class="hidden-sm hidden-xs">Login</span></a>
          </li>
        </ul>

      </div>
    </div>
  </div>

  <div class="container">

    <div class="main-header">
      <div class="row">

        <div class="col-md-4">
          <div id="logo">
            <a ui-sref="home">
              <img src="images/catalog/logo.png" title="Spice Shoppe" alt="Spice Shoppe" class="img-responsive"/>
            </a>
          </div>
        </div>

        <div class="col-md-5">
          <!--
          <pre>
            $state = {{$state.current.name}}
            $stateParams = {{$stateParams}}
            $state full url = {{ $state.$current.url.source }}
          </pre>
          -->

          <div id="search">
            <div class="input-group">
              <input type="text" class="form-control input-lg" placeholder="Search">
								  <span class="input-group-btn">
									<button class="btn btn-lg" type="button">
                                      <i class="fa fa-search"></i>
                                    </button>
								  </span>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div id="cart" class="btn-group btn-block" dropdown>
            <button type="button" data-toggle="dropdown" class="btn btn-block btn-lg dropdown-toggle">
              <i class="fa fa-shopping-cart"></i>
              <span class="hidden-md">Cart:</span><span id="cart-total">{{app.shoppingCart.items.length}} item(s) - {{app.formatPrice(app.shoppingCart.getTotalIncludingTax())}}</span>
              <i class="fa fa-caret-down"></i>
            </button>
            <ul class="dropdown-menu pull-right">
              <li>
                <div ng-if="app.shoppingCart.items.length==0">No items in cart
                </div>
                <div ng-if="app.shoppingCart.items.length>0">
                  <table class="table table-striped hcart">
                    <thead>
                    <td></td>
                    <td>Qnt x Product</td>
                    <td class="text-right">Tax</td>
                    <td class="text-right">Total</td>
                    <td></td>
                    </thead>
                    <tbody>
                    <tr ng-repeat="item in app.shoppingCart.items">

                      <td class="text-center">
                        <a ui-sref="product({productId:item.product.id})">
                          <img ng-src="images/{{item.product.image}}" alt="{{item.product.name}}" title="{{item.product.name}}" class="img-responsive img-thumbnail img-xs">
                        </a>
                      </td>
                      <td class="text-left">
                        {{item.quantity}} x
                        <a href="#/products/{{item.product.id}}">{{item.product.name}}</a>
                      </td>
                      <td class="text-right">
                        {{app.formatPrice(item.getTax())}}
                      </td>
                      <td class="text-right">
                        {{app.formatPrice(item.getTotalIncludingTax())}}
                      </td>
                      <td class="text-center">
                        <a href ng-click="app.shoppingCart.remove(item.product); $event.stopPropagation();"><i class="fa fa-times"></i></a>
                      </td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr ng-repeat="item in app.shoppingCart.totals">
                      <td></td>
                      <td></td>
                      <td class="text-right">{{item.title}}</td>
                      <td class="text-right">{{app.formatPrice(item.value)}}
                      </td>
                      <td></td>
                    </tr>
                    </tfoot>
                  </table>
                  <div class="row">
                    <div class="col-md-6">
                      <a ui-sref="cart" class="btn btn-block btn-warning"><i class="fa fa-shopping-cart"></i>
                        View Cart</a>
                    </div>
                    <div class="col-md-6">
                      <a ui-sref="checkout" class="btn btn-block btn-success">Checkout
                        <i class="fa fa-arrow-right"></i></a>
                    </div>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <nav id="main-menu" class="navbar" role="navigation">
      <div class="navbar-header">
        <button type="button" class="btn btn-navbar navbar-toggle" data-toggle="collapse" data-target=".navbar-cat-collapse">
          <span class="sr-only">Toggle Navigation</span>
          <i class="fa fa-bars"></i>
        </button>
      </div>
      <div class="collapse navbar-collapse navbar-cat-collapse yamm">
        <ul class="nav navbar-nav">
          <li class="dropdown yamm-fw" ng-repeat="item in categories">
            <a ui-sref="categories.detail({categoryId:item.id})" class="dropdown-toggle">{{item.name}}</a>
            <ul class="dropdown-menu">
              <li>
                <div class="yamm-content">
                  <div class="row">
                    <ul class="col-sm-2 list-unstyled" ng-repeat="child in item.children">
                      <li>
                        <p>
                          <strong><a ui-sref="categories.detail({categoryId:child.id})">{{child.name}}</a></strong>
                        </p>
                      </li>
                      <li ng-repeat="child2 in child.children">
                        <a ui-sref="categories.detail({categoryId:child2.id})">{{child2.name}}</a>
                      </li>
                    </ul>
                  </div>
                </div>
              </li>
              <li ng-repeat="child in item.children">

              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </div>

  <!--ajax loading bar-->
  <div class="loading-bar-container" style="position:relative">

  </div>

</header>

<div class="container">

  <div ncy-breadcrumb></div>
  <!--
  <ol class="ab-nav breadcrumb">
      <li ng-repeat="breadcrumb in breadcrumbs.get() track by breadcrumb.path" ng-class="{ active: $last }">
          <a ng-if="!$last" ng-href="#{{ breadcrumb.path }}" ng-bind="breadcrumb.label" class="margin-right-xs"></a>
          <span ng-if="$last" ng-bind="breadcrumb.label"></span>
      </li>
  </ol>
  -->

  <div class="alert {{notification.alertType('global')}}" ng-show="notification.isVisible('global')">
    <button type="button" class="close" ng-click="notification.hide('global')">&times;</button>
    <h4 ng-bind="notification.header('global')"></h4>
    <ul>
      <li ng-repeat="msg in notification.messages('global')" ng-bind="msg"></li>
    </ul>
  </div>
</div>

<div ui-view>

</div>


<p></p>

<footer id="footer-area">
  <div class="footer-links">
    <div class="container">
      <div class="col-md-2 col-sm-6">
        <h5>Information</h5>
        <ul>
          <li><a href="about.html">About Us</a></li>
          <li><a href="#">Delivery Information</a></li>
          <li><a href="#">Privacy Policy</a></li>
          <li><a href="#">Terms &amp; Conditions</a></li>
        </ul>
      </div>

      <div class="col-md-2 col-sm-6">
        <h5>My Account</h5>
        <ul>
          <li><a href="#">My orders</a></li>
          <li><a href="#">My merchandise returns</a></li>
          <li><a href="#">My credit slips</a></li>
          <li><a href="#">My addresses</a></li>
          <li><a href="#">My personal info</a></li>
        </ul>
      </div>

      <div class="col-md-2 col-sm-6">
        <h5>Service</h5>
        <ul>
          <li><a href="contact.html">Contact Us</a></li>
          <li><a href="#">Returns</a></li>
          <li><a href="#">Site Map</a></li>
          <li><a href="#">Affiliates</a></li>
          <li><a href="#">Specials</a></li>
        </ul>
      </div>
      <div class="col-md-2 col-sm-6">
        <h5>Follow Us</h5>
        <ul>
          <li><a href="#">Facebook</a></li>
          <li><a href="#">Twitter</a></li>
          <li><a href="#">RSS</a></li>
          <li><a href="#">YouTube</a></li>
        </ul>
      </div>

      <div class="col-md-4 col-sm-12 last">
        <h5>Contact Us</h5>
        <ul>
          <li>My Company</li>
          <li>
            1247 LB Nagar Road, Hyderabad, Telangana - 35
          </li>
          <li>
            Email: <a href="#">info@demolink.com</a>
          </li>
        </ul>
        <h4 class="lead">
          Tel: <span>1(234) 567-9842</span>
        </h4>
      </div>

    </div>
  </div>

  <div class="copyright">
    <div class="container">
      <p class="pull-left">
        &nbsp; Theme inspired/cloned by 2014 Spice Shoppe Stores (Designed By <a href="http://sainathchillapuram.com">Sainath Chillapuram)</a>
      </p>
      <ul class="pull-right list-inline">
        <li>
          <img src="images/payment-icon/cirrus.png" alt="PaymentGateway"/>
        </li>
        <li>
          <img src="images/payment-icon/paypal.png" alt="PaymentGateway"/>
        </li>
        <li>
          <img src="images/payment-icon/visa.png" alt="PaymentGateway"/>
        </li>
        <li>
          <img src="images/payment-icon/mastercard.png" alt="PaymentGateway"/>
        </li>
        <li>
          <img src="images/payment-icon/americanexpress.png" alt="PaymentGateway"/>
        </li>
      </ul>
    </div>
  </div>
</footer>

<!-- JavaScript Files -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>

<script src="bower_components/angular/angular.js"></script>
<script src="bower_components/angular-route/angular-route.js"></script>
<script src="bower_components/angular-ui-router/release/angular-ui-router.js"></script>
<script src="bower_components/angular-sanitize/angular-sanitize.js"></script>
<script src="bower_components/angular-touch/angular-touch.js"></script>

<script src="bower_components/angular-bootstrap/ui-bootstrap-tpls.js"></script>
<script src="bower_components/angular-loading-bar/build/loading-bar.js"></script>

<script src="bower_components/angular-bootstrap-lightbox/dist/angular-bootstrap-lightbox.js"></script>
<script src="bower_components/angular-auto-validate/dist/jcs-auto-validate.js"></script>
<script src="bower_components/angular-translate/angular-translate.js"></script>
<script src="bower_components/angular-breadcrumb/dist/angular-breadcrumb.js"></script>

<!--main app -->
<script src="front/app.js"></script>

<!--controllers -->
<script src="front/controllers/homeController.js"></script>
<script src="front/controllers/productController.js"></script>
<script src="front/controllers/productsController.js"></script>
<script src="front/controllers/categoriesController.js"></script>
<script src="front/controllers/loginController.js"></script>
<script src="front/controllers/compareController.js"></script>
<script src="front/controllers/accountController.js"></script>
<script src="front/controllers/checkoutController.js"></script>
<script src="front/controllers/checkoutSuccessController.js"></script>
<script src="front/controllers/wishlistController.js"></script>
<script src="front/controllers/cartController.js"></script>
<script src="front/controllers/pagerController.js"></script>


<!--factories -->
<script src="front/factories/app.js"></script>
<script src="front/factories/cart.js"></script>
<script src="front/factories/CollectionService.js"></script>
<script src="front/factories/AuthInterceptor.js"></script>
<script src="front/factories/addressService.js"></script>

<!--filters -->
<script src="front/filters/StoreCurrency.js"></script>

<!--services -->
<script src="front/services/dataContext.js"></script>
<script src="front/services/uiHelper.js"></script>

</body>
</html>