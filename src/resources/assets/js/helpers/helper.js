export default class Helper {
  static url(path) {
    return `${window.location.origin}${window.location.pathname}/${path}`;
  }

  static updateLang(lang) {
    window.localStorage.setItem('TRANSLATE-MANAGER-EDITABLE-LANG', lang)
  }

  static lang() {
    return window.localStorage.getItem('TRANSLATE-MANAGER-EDITABLE-LANG')
      ? window.localStorage.getItem('TRANSLATE-MANAGER-EDITABLE-LANG')
      : null;
  }
}