const { Client } = require("pg");
const config = require("config");

const db = !process.env.NODE_ENV
  ? {
      user: "postgres",
      password: config.get("postgresPassword"),
      host: "localhost",
      port: 5432,
      database: "fin_tracker"
    }
  : {
      connectionString: process.env.DATABASE_URL
    };
const client = new Client(db);
const connectClient = async () => {
  try {
    await client.connect();
  } catch (error) {
    console.log(error);
  }
};
module.exports = client;
connectClient();
