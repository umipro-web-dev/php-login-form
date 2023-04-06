import jwt from "jsonwebtoken";

const payload = {
    user_name: "ypa",
    exp: Math.floor(new Date().getTime() / 1000) + 60
}

const secret = "pass";

const token = jwt.sign(payload, secret);

console.log(token);





let decoded = {};

try { 
    decoded = jwt.verify(token, secret);
} catch (e) {
    console.log(e);
}



console.log(decoded);