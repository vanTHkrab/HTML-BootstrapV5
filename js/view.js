function sendViewCount() {
  fetch("server/view.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: "action=increment",
  })
    .then((response) => response.json())
    .then((data) => {
      console.log("View count updated:", data);
    })
    .catch((error) => {
      console.error("Error updating view count:", error);
    });
}

// Call the function when the page loads
window.onload = sendViewCount;
