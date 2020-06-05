import axios from "axios";
import React from "react";
import ReactDOM from "react-dom";

const FollowButton = ({ username, follows }) => {
  const [isFollowing, setFollow] = React.useState(follows);
  const [followers, setFollowers] = React.useState(undefined);

  React.useEffect(() => {
    if (followers === undefined) return;

    const followElement = document.querySelector("#followers strong");
    followElement.textContent = followers;
  }, [followers]);

  const toggleFollow = async () => {
    try {
      let path = `/follow/${username}`;

      await axios.post(path);
      const result = await axios.get(path);

      setFollow(prev => !prev);
      setFollowers(result.data);
    } catch (e) {
      if (e.response.status == 401) {
        window.location = "/login";
      } else {
        console.log(e);
      }
    }
  };

  if (isFollowing) {
    return (
      <button onClick={toggleFollow} className="btn btn-outline-dark ml-4">
        Unfollow
      </button>
    );
  }

  return (
    <button onClick={toggleFollow} className="btn btn-primary ml-4">
      Follow
    </button>
  );
};

const propsContainer = document.getElementById("follow-button");

if (propsContainer) {
  const props = Object.assign({}, propsContainer.dataset);

  ReactDOM.render(
    <FollowButton {...props} />,
    document.getElementById("follow-button")
  );
}

export default FollowButton;
