import 'dart:convert';

SignUpModel signUpModelFromJson(String str) =>
    SignUpModel.fromJson(json.decode(str));

String signUpModelToJson(SignUpModel data) => json.encode(data.toJson());

class SignUpModel {
  SignUpModel({
    required this.message,
    required this.data,
  });

  Message message;
  Data data;

  factory SignUpModel.fromJson(Map<String, dynamic> json) => SignUpModel(
        message: Message.fromJson(json["message"]),
        data: Data.fromJson(json["data"]),
      );

  Map<String, dynamic> toJson() => {
        "message": message.toJson(),
        "data": data.toJson(),
      };
}

class Data {
  Data({
    required this.token,
    required this.user,
  });

  String token;
  User user;

  factory Data.fromJson(Map<String, dynamic> json) => Data(
        token: json["token"],
        user: User.fromJson(json["user"]),
      );

  Map<String, dynamic> toJson() => {
        "token": token,
        "user": user.toJson(),
      };
}

class User {
  User({
    required this.firstname,
    required this.lastname,
    required this.email,
    required this.username,
    required this.image,
    required this.address,
    required this.status,
    this.emailVerified,
    this.smsVerified,
    this.kycVerified,
    required this.updatedAt,
    required this.createdAt,
    required this.id,
    required this.fullname,
    required this.userImage,
    required this.stringStatus,
    required this.emailStatus,
    required this.lastLogin,
    required this.kycStringStatus,
  });

  String firstname;
  String lastname;
  String email;
  String username;
  String image;
  Address address;
  int status;
  dynamic emailVerified;
  dynamic smsVerified;
  dynamic kycVerified;
  DateTime updatedAt;
  DateTime createdAt;
  int id;
  String fullname;
  String userImage;
  Status stringStatus;
  Status emailStatus;
  String lastLogin;
  Status kycStringStatus;

  factory User.fromJson(Map<String, dynamic> json) => User(
        firstname: json["firstname"],
        lastname: json["lastname"],
        email: json["email"],
        username: json["username"],
        image: json["image"],
        address: Address.fromJson(json["address"]),
        status: json["status"],
        emailVerified: json["email_verified"] ?? '',
        smsVerified: json["sms_verified"] ?? '',
        kycVerified: json["kyc_verified"] ?? '',
        updatedAt: DateTime.parse(json["updated_at"]),
        createdAt: DateTime.parse(json["created_at"]),
        id: json["id"],
        fullname: json["fullname"],
        userImage: json["userImage"],
        stringStatus: Status.fromJson(json["stringStatus"]),
        emailStatus: Status.fromJson(json["emailStatus"]),
        lastLogin: json["lastLogin"],
        kycStringStatus: Status.fromJson(json["kycStringStatus"]),
      );

  Map<String, dynamic> toJson() => {
        "firstname": firstname,
        "lastname": lastname,
        "email": email,
        "username": username,
        "image": image,
        "address": address.toJson(),
        "status": status,
        "email_verified": emailVerified,
        "sms_verified": smsVerified,
        "kyc_verified": kycVerified,
        "updated_at": updatedAt.toIso8601String(),
        "created_at": createdAt.toIso8601String(),
        "id": id,
        "fullname": fullname,
        "userImage": userImage,
        "stringStatus": stringStatus.toJson(),
        "emailStatus": emailStatus.toJson(),
        "lastLogin": lastLogin,
        "kycStringStatus": kycStringStatus.toJson(),
      };
}

class Address {
  Address({
    required this.address,
    required this.state,
    required this.zip,
    required this.country,
    required this.city,
  });

  String address;
  String state;
  String zip;
  String country;
  String city;

  factory Address.fromJson(Map<String, dynamic> json) => Address(
        address: json["address"],
        state: json["state"],
        zip: json["zip"],
        country: json["country"],
        city: json["city"],
      );

  Map<String, dynamic> toJson() => {
        "address": address,
        "state": state,
        "zip": zip,
        "country": country,
        "city": city,
      };
}

class Status {
  Status({
    required this.statusClass,
    required this.value,
  });

  String statusClass;
  String value;

  factory Status.fromJson(Map<String, dynamic> json) => Status(
        statusClass: json["class"],
        value: json["value"],
      );

  Map<String, dynamic> toJson() => {
        "class": statusClass,
        "value": value,
      };
}

class Message {
  Message({
    required this.success,
  });

  List<String> success;

  factory Message.fromJson(Map<String, dynamic> json) => Message(
        success: List<String>.from(json["success"].map((x) => x)),
      );

  Map<String, dynamic> toJson() => {
        "success": List<dynamic>.from(success.map((x) => x)),
      };
}
