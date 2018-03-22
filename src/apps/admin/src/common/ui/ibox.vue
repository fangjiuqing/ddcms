<template>
  <div>
    <div class="ibox">
      <div class="ibox-title">
        <slot name="header">
            <h5>
              <slot name="icon"/>
              {{title}}
              <small>{{summary}}</small>
            </h5>
        </slot>
      </div>
      <div class="ibox-content">
        <slot name="content"></slot>
        <div class="clearfix"></div>
      </div>
      <slot name="footer">
        <div class="ibox-footer">
        </div>
      </slot>
    </div>
    <div class="clearfix"></div>
  </div>
</template>

<script>
export default {
  name: 'IBox',
  props: {
    title: [String],
    summary: [String]
  },
  data () {
    return {}
  }
}
</script>
