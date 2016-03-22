@extends('loginapp')

@section('content')
<main class="demo-main mdl-layout__content">
  <h2 class="t-center mdl-color-text--white text-shadow">Reedemer</h2>
  <a id="top"></a>
  <div class="demo-container mdl-grid">
    <div class="mdl-cell mdl-cell--4-col mdl-cell--hide-tablet mdl-cell--hide-phone"></div>
    <div class="demo-content mdl-color--white mdl-shadow--4dp content mdl-color-text--grey-800 mdl-cell mdl-cell--4-col mdl-cell--12-col-tablet">

      <div class="mdl-card__title ">
        <h2 class="mdl-card__title-text">
          <i class="material-icons mdl-color-text--grey m-r-5 lh-13">account_circle</i>
          Login
        </h2>
      </div>
      <div class="p-l-20 p-r-20 p-b-20">
        <form action="#">
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label textfield-demo">
            <input class="mdl-textfield__input" type="text" id="sample3" />
            <label class="mdl-textfield__label" for="sample3">Username</label>
          </div>
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label textfield-demo">
            <input class="mdl-textfield__input" type="password" id="sample3" />
            <label class="mdl-textfield__label" for="sample3">Password</label>
          </div>

          <div class="m-t-20">
          <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect mdl-color--light-blue">
            Login
          </button>
          <button type="button" class="mdl-button mdl-js-button mdl-js-ripple-effect">
            Register
          </button>
          </div>

        </form>
      </div>


    </div>
  </div>
</main>
@endsection