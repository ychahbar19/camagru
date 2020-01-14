var post_array = document.querySelectorAll(".post-article");
var likeState = null;
var xhr = new XMLHttpRequest();

function get_like(id_post)
{
  xhr.open('GET', 'http://localhost:8888/W.I.P/camagru-wip/index.php?sub-action=like&id_post=' + id_post, true);
  xhr.setRequestHeader('X-Requested-Width', 'xmlhttprequest');
  xhr.onreadystatechange = function(){
    if(xhr.readyState === 4 && xhr.status === 200)
      console.log(xhr.responseText);
  };
  xhr.send();
}

function get_dislike(id_post)
{
  xhr.open('GET', 'http://localhost:8888/W.I.P/camagru-wip/index.php?sub-action=dislike&id_post=' + id_post, true);
  xhr.setRequestHeader('X-Requested-Width', 'xmlhttprequest');
  xhr.send();
}

function get_likeState()
{
    var id_post = this.parentElement.parentElement.parentElement.parentElement.parentElement.getAttribute('id');
    if (this.style.color === "black")
    {
      get_like(id_post);
      this.style.color = "red";
    }
    else if (this.style.color === "red")
    {
        get_dislike(id_post);
        this.style.color = "black";
    }
}

function like_manager()
{
  if (post_array)
  {
    var counter = post_array.length;
    for (var i = 0; i < counter; i++)
    {
      post_array[i].querySelector(".like").addEventListener('click', get_likeState);
    }
  }
}

like_manager();

var streaming = false;
var webcam_open_btn = document.querySelector(".open_webcam_btn");
var webcam_close_btn = document.querySelector(".close_webcam_btn");
var apply_calc_btn = document.querySelector(".apply_calc_btn");
var video = document.querySelector(".webcam_video");
var take_picture_btn = document.querySelector(".take_picture_btn");
var canvas = document.querySelector("#canvas");
var photo = document.querySelector("#photo");
var input_file = document.querySelector("input[type='file']");
var height = 0;
var width = 600;
var calc_checked_path;

if (document.querySelector(".option") != null)
  calc_checked_path = document.querySelector(".option").children[1].children[0].getAttribute("src");
function handleVideo(stream)
{
  video.srcObject = stream;
}

function videoError(e)
{
}

if (webcam_open_btn)
{
  webcam_open_btn.addEventListener("click", function(){
    navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia || navigator.oGetUserMedia;
    if (navigator.getUserMedia)
      navigator.getUserMedia({video:true}, handleVideo, videoError);
      // video.play();
  });

  video.addEventListener("canplay", function(){
    if (!streaming)
    {
      height = video.videoHeight / (video.videoWidth/width);
      video.setAttribute('width', width);
      video.setAttribute('height', height);
      canvas.setAttribute('width', width);
      canvas.setAttribute('height', height);
      streaming = true;
    }
    webcam_open_btn.parentElement.classList.add("d-none");
    webcam_open_btn.parentElement.classList.remove("d-flex");
    document.querySelector(".webcam_div").classList.remove("d-none");
    document.querySelector(".webcam_div").classList.add("d-flex");
    video.play();
  });

  webcam_close_btn.addEventListener("click", function(){
    document.location.reload(true);
  });

  var type_img = "";
  take_picture_btn.addEventListener("click", function(){
    photo.classList.remove("d-none");
    canvas.getContext('2d').drawImage(video, 0, 0, width, height);
    var data = canvas.toDataURL('image/png');
    photo.setAttribute('src', data);
    type_img = "webcam";
  });

  var error_msg = document.querySelector(".alert");
  var calc_list = document.querySelectorAll(".option");

  for(var i = 0; i < calc_list.length; i++)
  {
    calc_list[i].addEventListener("click", function (){
      calc_checked_path = this.children[1].children[0].getAttribute("src");
    });
  }

  var file_reader;
  var file_save = document.querySelector('#file_save');

  input_file.addEventListener("change", function () {
    var file_img = this.files[0];

    file_reader = new FileReader();
    file_reader.readAsDataURL(file_img);

    file_reader.onload = function(e) {
      photo.classList.remove("d-none");
      photo.setAttribute("src", file_reader.result);
      file_save.setAttribute("src", file_reader.result);
      type_img = "file";
    };
  });


  var new_img = "";
  var img_path = "";

  apply_calc_btn.addEventListener("click", function () {

    if (input_file.value === "" && photo.getAttribute("src") === "")
      error_msg.classList.remove("d-none");
    else
    {
      if (photo.getAttribute("src") !== "")
      {
        if (type_img === "file")
          img_path = file_save.getAttribute("src");
        else
          img_path = canvas.toDataURL('image/png');
      }
      error_msg.classList.add("d-none");

      if (img_path !== "")
      {
        console.log(img_path);
        var xhr = new XMLHttpRequest();
        var data = "img=" + img_path + "&calc=" + calc_checked_path + "&type=" + type_img;

        xhr.open('POST', 'http://localhost:8080/W.I.P/camagru-wip/index.php?action=apply_calc_to_img', true)
        xhr.onreadystatechange = function () {
          if (xhr.readyState === 4 && xhr.status === 200)
          {
            alert("ici");
            // new_img = document.cookie.replace(/(?:(?:^|.*;\s*)image\s*\=\s*([^;]*).*$)|^.*$/, "$1");
            // photo.setAttribute("src", "public/img/temp/" + new_img);
          }
        }

        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.send(data);
      }
    }
  });

  var send_picture_btn = document.querySelector(".send_picture_btn");

  send_picture_btn.addEventListener("click", function () {
    if (input_file.value === "" && photo.getAttribute("src") === "")
    error_msg.classList.remove("d-none");
    if (photo.getAttribute("src").indexOf("public/img/temp/") != -1)
    {
      var xhr = new XMLHttpRequest();
      var data = "image=" + photo.getAttribute("src");
      xhr.open('POST', 'http://localhost:8080/W.I.P/camagru-wip/index.php?action=post_new_img', true)
      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200)
        window.location.href = "http://localhost:8080/W.I.P/camagru-wip/index.php?action=user_profil";
      }
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      xhr.send(data);
    }

  });
}
