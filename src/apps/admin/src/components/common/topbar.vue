<template>
  <div class="app_topbar">
    <nav class="navbar navbar-default">
      <a class="navbar-brand" slot="brand" href="#">Brand</a>
      <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li>
            <a href="javascript:;" role="button" aria-haspopup="true" aria-expanded="false">
              <img src="@/assets/images/avatar.jpg" class="topbar_avatar" height="30">
            </a>
          </li>
        </ul>
      </div>
    </nav>
  </div>
</template>

<script>
import store from '@/store'
export default {
  name: 'topbar',
  store
}
</script>
