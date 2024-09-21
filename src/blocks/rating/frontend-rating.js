import { Rating, Typography } from "@mui/material";
// import LinearProgress, {
//   linearProgressClasses,
// } from "@mui/material/LinearProgress";
// import Box from "@mui/material/Box";
// import { styled } from "@mui/material/styles";
import { render, useState, useEffect } from "@wordpress/element";
import apiFetch from "@wordpress/api-fetch";

function LinearProgressWithLabel(props) {
  const BorderLinearProgress = styled(LinearProgress)(({ theme }) => ({
    height: 8,
    [`& .${linearProgressClasses.colorPrimary}`]: {
      backgroundColor:
        theme.palette.grey[theme.palette.mode === "light" ? 100 : 200],
    },
    [`& .${linearProgressClasses.bar}`]: {
      backgroundColor: theme.palette.mode === "light" ? "#faaf00" : "",
    },
  }));

  return (
    <Box sx={{ display: "flex", alignItems: "center" }}>
      <Box sx={{ width: "100%", mr: 1 }}>
        {/* <LinearProgress variant="determinate" {...props} /> */}
        <BorderLinearProgress variant="determinate" {...props} />
      </Box>
      <Box sx={{ minWidth: 35 }}>
        <Typography variant="body2" color="text.secondary">
          {`${Math.round(props.value)}%`}
        </Typography>
      </Box>
    </Box>
  );
}

function PostRating(props) {
  const [avgRating, setAvgRating] = useState(props.avgRating);
  const [permission, setPermission] = useState(props.loggedIn);

  const [progressFiveStar, setProgressFiveStar] = useState(
    props.fiveStarRatings
  );
  const [progressFourStar, setProgressFourStar] = useState(
    props.fourStarRatings
  );
  const [progressThreeStar, setProgressThreeStar] = useState(
    props.threeStarRatings
  );
  const [progressTwoStar, setProgressTwoStar] = useState(props.twoStarRatings);
  const [progressOneStar, setProgressOneStar] = useState(props.oneStarRatings);

  const [totalRating, setTotalRating] = useState(props.totalRatings);

  useEffect(() => {
    if (props.userPostRating) {
      setPermission(false);
    }
  }, []);

  return (
    <>
      <Rating
        value={avgRating}
        precision={0.5}
        onChange={async (event, rating) => {
          if (!permission) {
            return alert(
              "You have already rated this post or you may need to log in."
            );
          }
          // prevent multiple user ratings
          setPermission(false);

          const response = await apiFetch({
            // example.com/wp-json/nortic-plugin/v1/rate
            path: "np/v1/rate",
            method: "POST",
            data: {
              postID: props.postID,
              rating,
              ratingMode: props.ratingMode,
              cookieTime: props.cookieTime,
            },
          });

          if (response.status == 2) {
            setAvgRating(response.rating);
          }
          setTotalRating(response.total);
          setProgressFiveStar(response.fiveStarRatings);
          setProgressFourStar(response.fourStarRatings);
          setProgressThreeStar(response.threeStarRatings);
          setProgressTwoStar(response.twoStarRatings);
          setProgressOneStar(response.oneStarRatings);
        }}
      />
      {/* <p style={{ marginBottom: "1rem" }}>{totalRating} users rating</p> */}
      <Box sx={{ marginBottom: "1rem" }}>
        <Typography variant="body2" color="text.secondary">
          {totalRating} users rating
        </Typography>
      </Box>
      <Box
        sx={{ textAlign: "center", marginLeft: "auto", marginRight: "auto" }}
      >
        <Box
          sx={{ display: "flex", alignItems: "center", mb: 1, width: "100%" }}
        >
          <Typography variant="body2" color="text.secondary">
            5 star
          </Typography>
          <Box sx={{ width: "80%", ml: 1 }}>
            <LinearProgressWithLabel value={progressFiveStar} />
          </Box>
        </Box>
        <Box
          sx={{ display: "flex", alignItems: "center", mb: 1, width: "100%" }}
        >
          <Typography variant="body2" color="text.secondary">
            4 star
          </Typography>
          <Box sx={{ width: "80%", ml: 1 }}>
            <LinearProgressWithLabel value={progressFourStar} />
          </Box>
        </Box>
        <Box
          sx={{ display: "flex", alignItems: "center", mb: 1, width: "100%" }}
        >
          <Typography variant="body2" color="text.secondary">
            3 star
          </Typography>
          <Box sx={{ width: "80%", ml: 1 }}>
            <LinearProgressWithLabel value={progressThreeStar} />
          </Box>
        </Box>
        <Box
          sx={{ display: "flex", alignItems: "center", mb: 1, width: "100%" }}
        >
          <Typography variant="body2" color="text.secondary">
            2 star
          </Typography>
          <Box sx={{ width: "80%", ml: 1 }}>
            <LinearProgressWithLabel value={progressTwoStar} />
          </Box>
        </Box>
        <Box
          sx={{ display: "flex", alignItems: "center", mb: 1, width: "100%" }}
        >
          <Typography variant="body2" color="text.secondary">
            1 star
          </Typography>
          <Box sx={{ width: "80%", ml: 1 }}>
            <LinearProgressWithLabel value={progressOneStar} />
          </Box>
        </Box>
      </Box>
    </>
  );
}

document.addEventListener("DOMContentLoaded", () => {
  const block = document.querySelector("#post-type-rating");

  const postID = parseInt(block.dataset.postId);
  const avgRating = parseFloat(block.dataset.avgRating);
  const loggedIn = !!block.dataset.loggedIn; // boolean
  const userPostRating = !!parseInt(block.dataset.userPostRating);
  const ratingMode = block.dataset.ratingMode;
  const cookieTime = parseInt(block.dataset.cookieTime);
  const totalRatings = parseInt(block.dataset.totalRatings);
  const oneStarRatings = parseInt(block.dataset.oneStarRatings);
  const twoStarRatings = parseInt(block.dataset.twoStarRatings);
  const threeStarRatings = parseInt(block.dataset.threeStarRatings);
  const fourStarRatings = parseInt(block.dataset.fourStarRatings);
  const fiveStarRatings = parseInt(block.dataset.fiveStarRatings);

  //   console.log(postID, avgRating, loggedIn);

  render(
    <PostRating
      postID={postID}
      avgRating={avgRating}
      loggedIn={loggedIn}
      userPostRating={userPostRating}
      ratingMode={ratingMode}
      cookieTime={cookieTime}
      totalRatings={totalRatings}
      oneStarRatings={oneStarRatings}
      twoStarRatings={twoStarRatings}
      threeStarRatings={threeStarRatings}
      fourStarRatings={fourStarRatings}
      fiveStarRatings={fiveStarRatings}
    />,
    block
  );
});
