function websocket(accesstoken, feedName, feedValue) {
    var conn = new WebSocket(`wss://streams.myespresso.com/espstream/api/stream?ACCESS_TOKEN=${accesstoken}`);
  
    conn.onopen = function(e) {
      console.log("WebSocket connection established");
  
      // Subscribe to the feed
      var subscribe_message = {
        "action": "subscribe",
        "key": ["feed"],
        "value": [""]
      };
      conn.send(JSON.stringify(subscribe_message));
  
      // Request for the specified feed data
      var feed_request_message = {
        "action": "feed",
        "key": [feedName],
        "value": [feedValue]
      };
      conn.send(JSON.stringify(feed_request_message));
    };
  
    conn.onmessage = function(e) {
      console.log("WebSocket message received:", e.data);
      if (e.data === "heartbeat") {
        console.log("Heartbeat received");
      } else {
        var message = JSON.parse(e.data);
        // handle other types of messages
      }
    };
  
    conn.onerror = function (evt) {
      console.log("WebSocket error:", evt);
    };
  
    conn.onclose = function (evt) {
      console.log("WebSocket connection closed");
    };
  }
  