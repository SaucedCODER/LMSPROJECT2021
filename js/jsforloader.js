
const dot_one = document.querySelector(".loaditem:nth-child(1)");
const dot_three = document.querySelector(".loaditem:nth-child(3)");
const dot_five = document.querySelector(".loaditem:nth-child(5)");
const dot_two_four = document.querySelectorAll(".loaditem:nth-child(even)");
const loader = document.querySelector(".loader");
  let dot_one_animation = dot_one.style.animation;

  if (!dot_one_animation.includes("resize-animation-one")) {
    dot_one.style.animation = "resize-animation-one .7s 0.2s infinite";
    dot_five.style.animation = "resize-animation-one .7s 0.2s infinite";
  } else {
    dot_one.style.animation = "none";
    dot_five.style.animation = "none";
  }

  let dot_two_animation = dot_two_four[0].style.animation;

  if (!dot_two_animation.includes("resize-animation-two")) {
    dot_two_four.forEach((el) => {
      el.style.animation = "resize-animation-two .7s 0.3s infinite";
    });
  } else {
    dot_two_four.forEach((el) => {
      el.style.animation = "none";
    });
  }

  let dot_three_animation = dot_three.style.animation;

  if (!dot_three_animation.includes("resize-animation-three")) {
    dot_three.style.animation = "resize-animation-three 1s 0.2s infinite";
  } else {
    dot_three.style.animation = "none";
  }
