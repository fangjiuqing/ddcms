export default {
  install (v, opt) {
    v.prototype.$util = this
  },
  rand_str (len) {
    const text = 'abcdefghijklmnopqrstuvwxyz0123456789'
    const rdmIndex = text => Math.random() * text.length | 0
    let rdmString = ''
    for (; rdmString.length < len;) {
      rdmString += text.charAt(rdmIndex(text))
    }
    return rdmString
  }
}
