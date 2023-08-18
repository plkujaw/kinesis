const tablinks = document.querySelectorAll('.tablink');

tablinks.forEach((tablink, index) => {
  tablink.addEventListener('click', (e) => {
    openTab(e, `tab-${index + 1}`);
  });
});

function openTab(evt, tabId) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName('tabcontent');
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = 'none';
  }
  tablinks = document.getElementsByClassName('tablink');
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(' active', '');
  }
  document.getElementById(tabId).style.display = 'block';
  evt.currentTarget.className += ' active';
}
