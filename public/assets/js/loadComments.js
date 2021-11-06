window.onload = () => {
  const loadmoreButton = document.querySelector("[data-loadmore]");
  let loadtimes = loadmoreButton.getAttribute("data-loadtimes");
  const commentsNb = loadmoreButton.getAttribute("data-commentsnb");
  const trickId = loadmoreButton.getAttribute("data-trickid");
  const commentsContainer = document.querySelector(".comments");
  loadmoreButton.href = `/figures/loadcomments/${loadtimes}`;
  const loadComments = (event) => {
    event.preventDefault();
    const url = event.target.href;
    axios({
      method: "post",
      // with method get => url: url + "?trickid=" + trickId,
      url: url + "?trickid=" + trickId,
      data: { trickid: trickId },
    }).then(function (response) {
      console.log(response);
      const comments = response.data;
      loadmoreButton.setAttribute("data-loadtimes", loadtimes);
      comments.forEach((data) => {
        commentsContainer.insertAdjacentHTML("beforeend", insertComment(data));
      });
      loadtimes++;
      if (commentsNb <= 3 * loadtimes) {
        loadmoreButton.remove();
      } else {
        loadmoreButton.href = `/figures/loadcomments/${loadtimes}`;
      }
    });
  };
  loadmoreButton.addEventListener("click", loadComments);
};

const insertComment = (data) => {
  return `<div class="row py-3 align-items-center comment-container">
  <div class="col-sm-3 comment-profile">
    <img src="${data.photo}"
      alt="Raised circle image"
      class="img-fluid rounded-circle shadow-lg"
      style="width: 150px;height:130px" />
    <small class="text-uppercase font-weight-bold">
      ${data.firstname ? data.firstname + data.lastname : data.username}
    </small>
  </div>
  <div class="col-sm-9">
    <p class="mb-0">
      ${data.content}
    </p>
    <span class="badge badge-pill badge-info text-uppercase">
      Crée le : ${data.createdAt}
    </span>
  </div>
</div>`;
};
