import { toast, disabled } from "./function.js";

const RequestType = {
  AUTH: "auth",
  FETCH: "fetch",
};

const ResponseType = {
  SUCCESS: "success",
  ERROR: "error",
};

async function request(url, onSuccess, options = {}) {
  const defaultOptions = {
    method: "POST",
    data: null,
    type: "create",
    button: null,
    headers: {},
  };

  const { method, data, type, button, headers } = { ...defaultOptions, ...options };

  try {
    const response = await fetch(url, { method, body: data, headers });

    if (!response.ok) {
      throw new Error('Request failed');
    }

    // const responseData = await response.text();
    // console.log(responseData);
    
    const responseData = await response.json();

    if (button !== null) {
      disabled(button, 'enabled');
    }

    if (type === RequestType.AUTH && responseData.type === ResponseType.SUCCESS) {
      location.href = responseData.message;
      return;
    }

    if (type === RequestType.FETCH && responseData.type === ResponseType.SUCCESS) {
      onSuccess(responseData.message);
      return
    }

    toast(responseData.type, responseData.message);

    if (responseData.type === ResponseType.SUCCESS) {
      onSuccess();
    }
  } catch (error) {
    toast('error', error.message);
  }
}

export default request;