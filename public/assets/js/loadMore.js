window.onload = () => {
  const loadmoreButton = document.querySelector("[data-loadmore]");
  let loadtimes = loadmoreButton.getAttribute("data-loadtimes");
  const tricksNb = loadmoreButton.getAttribute("data-tricksnb");
  const cards = document.querySelector(".cards");
  loadmoreButton.href = `/figures/loadmore/${loadtimes}`;
  const loadMore = (event) => {
    event.preventDefault();
    const url = event.target.href;
    axios.get(url).then(function (response) {
      const tricks = response.data;
      loadmoreButton.setAttribute("data-loadtimes", loadtimes);
      tricks.forEach((data) => {
        cards.insertAdjacentHTML("beforeend", insertTrick(data));
      });
      loadtimes++;
      if (tricksNb <= 3 * loadtimes) {
        loadmoreButton.remove();
      } else {
        loadmoreButton.href = `/figures/loadmore/${loadtimes}`;
      }
    });
  };
  loadmoreButton.addEventListener("click", loadMore);
};

const insertTrick = (data) => {
  const hoverInfo = `<div class="card__info-hover">
  <form method="post"
    action="/figures/${data.id}"
    onsubmit="return confirm('Are you sure you want to delete this item?');">
    <input type="hidden"
      name="_token"
      value="${data.token.value}" />
    <button class="delete_button" type="submit">
      <svg id="Layer_1"
        onclick="deleteTrick(e)"
        class="card__like"
        data-name="Layer 1"
        xmlns="http://www.w3.org/2000/svg"
        xmlns:xlink="http://www.w3.org/1999/xlink"
        viewBox="0 0 512 512">
        <defs>
          <linearGradient id="linear-gradient"
            x1="256"
            x2="256"
            y2="512"
            gradientUnits="userSpaceOnUse">
            <stop offset="0" stop-color="#e9ebf5" />
            <stop offset="0.76" stop-color="#b0c7e1" />
            <stop offset="1" stop-color="#7697c6" />
          </linearGradient>
          <linearGradient id="linear-gradient-2"
            x1="256"
            y1="399.41"
            x2="256"
            y2="112.59"
            gradientUnits="userSpaceOnUse">
            <stop offset="0" stop-color="#000013" />
            <stop offset="1" stop-color="#005c92" />
          </linearGradient>
        </defs>
        <path d="M256,512c141,0,256-115,256-256S397,0,256,0,0,115,0,256,115,512,256,512Z"
          fill-rule="evenodd"
          fill="url(#linear-gradient)" />
        <path d="M352.39,119.31l29.85,29.86a23.09,23.09,0,0,1,0,32.57L308,256l74.27,74.27a23.1,23.1,0,0,1,0,32.57l-29.86,29.85a23.1,23.1,0,0,1-32.57,0l-74.26-74.26-74.27,74.26a23.1,23.1,0,0,1-32.57,0l-29.85-29.85a23.1,23.1,0,0,1,0-32.57L183.14,256l-74.27-74.26a23.09,23.09,0,0,1,0-32.57l29.85-29.86a23.1,23.1,0,0,1,32.57,0l74.27,74.26,74.26-74.26A23.1,23.1,0,0,1,352.39,119.31Z"
          fill="#fff"
          fill-rule="evenodd" />
        <path d="M362.84,119.31l29.85,29.86a23.08,23.08,0,0,1,0,32.57L318.43,256l74.26,74.27a23.08,23.08,0,0,1,0,32.57l-29.85,29.85a23.11,23.11,0,0,1-32.58,0L256,318.43l-74.27,74.26a23.09,23.09,0,0,1-32.56,0l-29.86-29.85a23.1,23.1,0,0,1,0-32.57L193.57,256l-74.26-74.26a23.09,23.09,0,0,1,0-32.57l29.86-29.86a23.09,23.09,0,0,1,32.56,0L256,193.58l74.26-74.26A23.11,23.11,0,0,1,362.84,119.31Z"
          fill-rule="evenodd"
          fill="url(#linear-gradient-2)" />
      </svg>
    </button>
  </form>
  <div class="card__clock-info">
    <a href="/modifier/${data.id}">
      <svg id="Layer_1"
        class="card__clock"
        data-name="Layer 1"
        xmlns="http://www.w3.org/2000/svg"
        xmlns:xlink="http://www.w3.org/1999/xlink"
        viewBox="0 0 512 512">
        <defs>
          <linearGradient id="linear-gradient"
            x1="256"
            x2="256"
            y2="512"
            gradientUnits="userSpaceOnUse">
            <stop offset="0" stop-color="#e9ebf5" />
            <stop offset="0.76" stop-color="#b0c7e1" />
            <stop offset="1" stop-color="#7697c6" />
          </linearGradient>
          <linearGradient id="linear-gradient-2"
            x1="256"
            y1="420.59"
            x2="256"
            y2="91.41"
            gradientUnits="userSpaceOnUse">
            <stop offset="0" stop-color="#000013" />
            <stop offset="1" stop-color="#005c92" />
          </linearGradient>
        </defs>
        <title>
          edit
        </title>
        <path d="M256,512c141,0,256-115,256-256S397,0,256,0,0,115,0,256,115,512,256,512Z"
          fill-rule="evenodd"
          fill="url(#linear-gradient)" />
        <path d="M141.25,329,268.83,167.23,141.25,329ZM184,362.54,311.55,200.79,184,362.54ZM238.67,150l24.62,19.83L141.2,324.59c-2.4-13.28-6.11-24.11-11.9-36.74l-1.1-.88.44-.54v0h0L238.67,150l34.64-43c13.47-16.71,36.64-20.6,51.48-8.64l48.43,39c14.84,12,16,35.42,2.49,52.13l-34.33,42.58L230.6,369.48l-.76-.62-.11.4c-13.69-8-25.89-9.87-41.11-8.14L309.9,207.35l-4.31-3.46L185,356.85c-4.57-21.66-12.76-31.26-40.08-28L267.59,173.26l4.16,3.36,33.84,27.27,4.31,3.46h0l31.16,25.11.31-.38,14.75-18.3L253.73,131.27,238.67,150Zm9-10.73,102,82.25-1,1.27-1,1.27-102-82.25,1-1.27h0l1-1.27ZM116.51,344.79,105,397.69c-5.46,25,.5,27.36,22.71,17.42l49-21.89C146,381.16,132.11,370.61,116.51,344.79Z"
          fill="#fff"
          fill-rule="evenodd" />
        <path d="M153.15,329,280.73,167.23,153.15,329Zm42.73,33.57L323.46,200.79,195.88,362.54ZM250.57,150l24.62,19.83L153.09,324.59c-2.39-13.28-6.11-24.11-11.89-36.74l-1.1-.88.44-.54,0,0h0L250.57,150l34.63-43c13.48-16.71,36.64-20.6,51.48-8.64l48.43,39c14.84,12,16,35.42,2.48,52.13l-34.32,42.58L242.51,369.48l-.77-.62-.11.4c-13.7-8-25.9-9.87-41.11-8.14L321.81,207.35l-4.31-3.46-120.65,153c-4.57-21.66-12.76-31.26-40.08-28L279.49,173.26l4.17,3.36,33.84,27.27,4.31,3.46h0L353,232.46l.31-.38L368,213.78l-102.4-82.51L250.57,150Zm9-10.73,102,82.25-1,1.27-1,1.27-102-82.25,1-1.27h0l1-1.27ZM128.42,344.79l-11.54,52.9c-5.46,25,.51,27.36,22.72,17.42l48.94-21.89C157.89,381.16,144,370.61,128.42,344.79Z"
          fill-rule="evenodd"
          fill="url(#linear-gradient-2)" />
      </svg><span class="card__time">Modifier</span>
    </a>
  </div>
</div>`;
  return `<article class="card card--2">
      ${data.isConnected ? hoverInfo : ""}
    <div class="card__img"
      style="background-image: url('/uploads/${data.image}');"></div>
    <a href="/figures/${data.slug}"
      class="card_link">
      <div class="card__img--hover"
        style="background-image: url('/uploads/${data.image}');"></div>
    </a>
    <div class="card__info">
      <span class="card__category">${data.group}</span>
      <h3 class="card__title">
      ${data.name}
      </h3>
      <span class="card__by">
        by: <a href="#" class="card__author" title="author">${data.author}</a>
      </span>
    </div>
  </article>`;
};
