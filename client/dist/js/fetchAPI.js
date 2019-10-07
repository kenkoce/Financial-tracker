const h = new Headers();

const BASE_URL = !process.env.NODE_ENV ? "http://localhost:7000/api" : "/api";

const token = localStorage.getItem("token");
h.append("Content-type", "application/json");
h.append("x-auth-token", token);

class FetchAPI {
  // HTTP GET Request
  async get(url, cbFunction) {
    this.url = url;

    await fetch(BASE_URL + url, {
      method: "GET",
      headers: h,
      mode: "cors"
    })
      .then(async response => {
        return {
          data: await response.json(),
          status: await response.status
        };
      })
      .then(cbFunction)
      .catch(err => {
        console.log(err);
      });
  }

  // HTTP Post Request
  async post(url, body, cbFunction) {
    this.url = url;
    this.body = body;

    await fetch(BASE_URL + url, {
      method: "POST",
      headers: h,
      mode: "cors",
      body: JSON.stringify(body)
    })
      .then(async response => {
        return {
          data: await response.json(),
          status: response.status
        };
      })
      .then(cbFunction)
      .catch(err => {
        console.log(err);
      });
  }

  // HTTP PUT Request
  async put(url, body, cbFunction) {
    this.url = url;
    this.body = body;

    await fetch(BASE_URL + url, {
      method: "PUT",
      headers: h,
      mode: "cors",
      body: JSON.stringify(body)
    })
      .then(async response => {
        return {
          data: await response.json(),
          status: response.status
        };
      })
      .then(cbFunction)
      .catch(err => {
        console.log(err);
      });
  }

  async delete(url, cbFunction) {
    this.url = url;

    await fetch(BASE_URL + url, {
      method: "DELETE",
      headers: h
    })
      .then(async response => {
        return {
          data: await response.json(),
          status: response.status
        };
      })
      .then(cbFunction)
      .catch(err => {
        console.log(err);
      });
  }
}
