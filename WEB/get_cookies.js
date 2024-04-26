function getCookies() {
  let cookies = document.cookie.split("; ");
  let result = {};
  for (let i = 0; i < cookies.length; i++) {
    let cookie = cookies[i].split("=");
    result[cookie[0]] = cookie[1];
  }
  return result;
}