function create_clock(el) {
  var today = new Date();
  var h = today.getHours();
  var m = today.getMinutes();
  var s = today.getSeconds();
  h = clock_checkTime(h);
  m = clock_checkTime(m);
  s = clock_checkTime(s);
  $(el).get(0).innerHTML =
  h + ":" + m + ":" + s;
  var t = setTimeout(()=>{create_clock(el)}, 500);
}
function clock_checkTime(i) {
  if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
  return i;
}