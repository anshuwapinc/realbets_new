var socket = require("./node_modules/socket.io");
var express = require("express");
var app = express();
var server = require("http").createServer(app);
var io = socket.listen(server);
var port = process.env.PORT || 3000;
server.listen(port, function () {
  console.log("Server listening at port %d", port);
});
app.io = io;
app.io.attach(server);
var router = express.Router();
var url = require("url");
var qs = require("querystring");
var bodyParser = require("body-parser");

var mysql = require("mysql");
var util = require("util");

io.on("connection", function (socket) {
  socket.on("market_update", function (data) {
    io.sockets.emit("market_update", {
      marketodds: data.marketodds,
    });
  });

  socket.on("fancy_update", function (data) {
     io.sockets.emit("fancy_update", {
      fantacy: data.fantacy,
    });
  });

  socket.on("casino_market_update", function (data) {
    io.sockets.emit("casino_market_update", {
      marketodds: data.marketodds,
    });
  });

  socket.on("betting_settle", function (data) {
    io.sockets.emit("betting_settle", {
      betting_detail: data.betting_detail,
    });
  });

  socket.on("betting_placed", function (data) {
    io.sockets.emit("betting_placed", {
      betting_details: data.betting_details,
    });

    console.log("message call", data.betting_details);
  });

  socket.on("hard_refresh", function (data) {
    io.sockets.emit("hard_refresh", {
      hard_refresh: data.hard_refresh,
    });

    console.log("hard refresh call", data.hard_refresh);
  });

  socket.on("block_markets", function (data) {
    io.sockets.emit("block_markets", {
      data: data.data,
    });

    console.log("message call", data.data);
  });
});

app.use(
  express.urlencoded({
    extended: true,
  })
);

app.use(express.json());
//  app.use(bodyParser.urlencoded({ limit: "50mb", extended: true, parameterLimit: 50000000 }));

// app.use(bodyParser.json({ type: 'application/*+json' }))
var jsonParser = bodyParser.json();

app.post("/", jsonParser, function (req, res) {
  if (req.method == "POST") {
    var data = "";
    io.sockets.emit("market_update", {
      marketodds: req.body,
    });
  }
  res.send(true);
  // res.render('index', { title: 'Express' });
});

// app.post("/fancyupdate", jsonParser, function (req, res) {
//   if (req.method == "POST") {
//     var data = "";
//     io.sockets.emit("fancy_update", {
//       fantacy: req.body,
//     });
//   }
//   res.send(true);
//   // res.render('index', { title: 'Express' });
// });

app.post("/betting_settle", jsonParser, function (req, res) {
  if (req.method == "POST") {
    var data = "";
    io.sockets.emit("betting_settle", {
      betting_detail: req.body,
    });
  }
  res.send(true);
});

// var my_connection = mysql.createConnection({
//   host: "localhost",
//   user: "root",
//   password: "123456",
//   database: "exchange2",
// });

var my_connection = mysql.createConnection({
  host: "161.35.94.46",
  user: "root",
  password: "GyanBissa@79",
  database: "exchange",
  timezone: "utc",
});
// res.locals.connection.connect();

const query = util.promisify(my_connection.query).bind(my_connection);

// getListEvents = (data) => {
//   return new Promise((resolve, rejector) => {
//     query(
//       "SELECT le.competition_id, le.event_type, le.event_id, le.event_name, le.open_date from `list_events` as `le`"
//     )
//       .then((player) => {
//         resolve(player);
//       })
//       .catch((err) => {
//         console.log(err);
//         rejector(err);
//       });
//   });
// };

checkPlayerExistance = () => {
  return new Promise((resolve, rejector) => {
    query(
      "SELECT le.competition_id, le.event_type, le.event_id, le.event_name, le.open_date from `list_events` as `le` WHERE le.updated_at >=DATE_SUB(NOW(),INTERVAL 15 MINUTE) and le.is_casino = 'No'"
    )
      .then((player) => {
        resolve(player);
      })
      .catch((err) => {
        console.log(err);
        rejector(err);
      });
  });
};

app.get("/addCompetition", async (req, res) => {
  let list_events = await checkPlayerExistance();
  let player = await getMarketTypes(list_events);

  io.sockets.emit("market_update", {
    marketodds: player,
  });

  // let market_book_odds_fancy = await getMarketBookOddsFancy(list_events);
 
  // io.sockets.emit("fancy_update", {
  //   fantacy: market_book_odds_fancy,
  // });


  res.send(
    JSON.stringify({
      status: 200,
      error: null,
      response: player,
      // response: null,
    })
  );
});

async function getMarketTypes(list_event) {
  var newArr = [];
  for (const elem of list_event) {
    var event_id = elem.event_id;

    let market_types = await query(
      "SELECT `mt`.`market_id`, `mt`.`market_name`,`mt`.`timer`, `mt`.`market_start_time`, `mt`.`runner_1_selection_id`, `mt`.`runner_1_runner_name`, `mt`.`runner_2_selection_id`, `mt`.`runner_2_runner_name`, `mbo`.`status`, `mbo`.`inplay`, `mbo`.`complete` FROM `market_types` as `mt` JOIN `market_book_odds` as `mbo` ON `mbo`.`market_id` = `mt`.`market_id`  WHERE `mt`.`event_id` = '" +
        event_id +
        "' and mt.updated_at >=DATE_SUB(NOW(),INTERVAL 15 MINUTE) "
    );

    const tmp_market_types = await getRunners(market_types, event_id);
    elem["market_types"] = market_types;

    // const newElem = await getMarketTypesData(event_id);
    newArr.push(elem);
  }
   return newArr;
}

async function getRunners(market_types, event_id) {
  var newArr = [];
  for (const elem of market_types) {
    var market_id = elem.market_id;
    // newArr[event_id] = elem;

    let runners = await query(
      "SELECT * FROM `market_book_odds_runner` WHERE `market_id` = '" +
        market_id +
        "' AND `event_id` = '" +
        event_id +
        "' and market_book_odds_runner.updated_at >=DATE_SUB(NOW(),INTERVAL 6 HOUR) ORDER BY `id` ASC"
    );
    elem["runners"] = runners;

    newArr.push(elem);
  }
  return newArr;
}

getListEvents = () => {
  return new Promise((resolve, rejector) => {
    query(
      "SELECT le.competition_id, le.event_type, le.event_id, le.event_name, le.open_date from `list_events` as `le` where  le.updated_at >=DATE_SUB(NOW(),INTERVAL 6 HOUR) "
    )
      .then((player) => {
        resolve(player);
      })
      .catch((err) => {
        console.log(err);
        rejector(err);
      });
  });
};

async function getFancyBlockMarket(market_book_odds_fancy) {
  var newArr = [];
  for (const elem of market_book_odds_fancy) {
    var selection_id = elem.selection_id;
    var match_id = elem.match_id;

    let block_all_market = await query(
      "SELECT user_id,fancy_id,type FROM `block_markets` WHERE `type` = 'AllFancy' AND `event_id` = '" +
        match_id +
        "'"
    );

    let block_market = await query(
      "SELECT user_id,fancy_id,type FROM `block_markets` WHERE `fancy_id` = '" +
        selection_id +
        "' AND `event_id` = '" +
        match_id +
        "' ORDER BY `block_market_id` ASC"
    );
    elem["block_market"] = block_market;
    elem["block_all_market"] = block_all_market;

    newArr.push(elem);
  }
  return newArr;
}

async function getMarketBookOddsFancy(list_event) {

  return false;
  console.log('here call');
  var newArr = [];
  for (const elem of list_event) {
    var event_id = elem.event_id;
    // newArr[event_id] = elem;

    console.log("SELECT id,match_id,selection_id,runner_name,lay_price1,lay_size1,back_price1,back_size1,game_status,mark_status,is_active,cron_disable from market_book_odds_fancy where match_id='" +
    event_id +
    "' and is_active = 'Yes'");
    let market_book_odds_fancy = await query(
      "SELECT id,match_id,selection_id,runner_name,lay_price1,lay_size1,back_price1,back_size1,game_status,mark_status,is_active,cron_disable from market_book_odds_fancy where match_id='" +
        event_id +
        "' and is_active = 'Yes'"
    );

     elem["fancy_data"] = market_book_odds_fancy;

    newArr.push(elem);
  }
  return newArr;
}
 

app.get("/getMarketBookOddsFancy", async (req, res) => {
  let list_events = await getListEvents();
  let market_book_odds_fancy = await getMarketBookOddsFancy(list_events);
 
  res.send(JSON.stringify({ status: 200, error: null, response: market_book_odds_fancy }));
});


async function getOpenMarkets(list_event) {
  var event_id = list_event.event_id;

  let market_types = await query(
    "SELECT `mt`.`market_id`, `mt`.`market_name`, `mt`.`market_start_time`, `mt`.`runner_1_selection_id`, `mt`.`runner_1_runner_name`, `mt`.`runner_2_selection_id`, `mt`.`runner_2_runner_name`, `mbo`.`status`, `mbo`.`inplay`, `mbo`.`complete` FROM `market_types` as `mt` JOIN `market_book_odds` as `mbo` ON `mbo`.`market_id` = `mt`.`market_id`  WHERE `mt`.`event_id` = '" +
      event_id +
      "'"
  );

  return market_types;
}

/*************************Casino Event**********************/

getCasinoEvents = () => {
  return new Promise((resolve, rejector) => {
    query(
      "SELECT le.competition_id, le.event_type, le.event_id, le.event_name, le.open_date from `list_events` as `le` WHERE le.updated_at >=DATE_SUB(NOW(),INTERVAL 15 MINUTE) and is_casino = 'Yes'"
    )
      .then((player) => {
        resolve(player);
      })
      .catch((err) => {
        console.log(err);
        rejector(err);
      });
  });
};

async function getCasinoMarketTypes(list_event) {
  var newArr = [];
  for (const elem of list_event) {
    var event_id = elem.event_id;
  
    let market_types = await query(
      "SELECT `mt`.`market_id`, `mt`.`market_name`,`mt`.`timer`, `mt`.`market_start_time`, `mt`.`runner_1_selection_id`, `mt`.`runner_1_runner_name`, `mt`.`runner_2_selection_id`, `mt`.`runner_2_runner_name`, `mbo`.`status`, `mbo`.`inplay`, `mbo`.`complete` FROM `market_types` as `mt` JOIN `market_book_odds` as `mbo` ON `mbo`.`market_id` = `mt`.`market_id`  WHERE `mt`.`event_id` = '" +
        event_id +
        "' and  mt.updated_at >=DATE_SUB(NOW(),INTERVAL 5 MINUTE) "
    );

    const tmp_market_types = await getRunners(market_types, event_id);
    elem["market_types"] = market_types;

    // const newElem = await getMarketTypesData(event_id);
    newArr.push(elem);
  }
   return newArr;
}

app.get("/send-casino-response", async (req, res) => {
  let list_events = await getCasinoEvents();

  let player = await getCasinoMarketTypes(list_events);

  io.sockets.emit("casino_market_update", {
    marketodds: player,
  });

  // let market_book_odds_fancy = await getMarketBookOddsFancy(list_events);
  // io.sockets.emit("fancy_update", {
  //   fantacy: market_book_odds_fancy,
  // });

  res.send(
    JSON.stringify({
      status: 200,
      error: null,
      response: player,
      // response: null,
    })
  );
});
