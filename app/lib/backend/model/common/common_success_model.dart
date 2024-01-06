import 'dart:convert';

CommonSuccessModel commonSuccessModelFromJson(String str) =>
    CommonSuccessModel.fromJson(json.decode(str));

String commonSuccessModelToJson(CommonSuccessModel data) =>
    json.encode(data.toJson());

class CommonSuccessModel {
  CommonSuccessModel({
    required this.message,
  });

  Message message;

  factory CommonSuccessModel.fromJson(Map<String, dynamic> json) =>
      CommonSuccessModel(
        message: Message.fromJson(json["message"]),
      );

  Map<String, dynamic> toJson() => {
        "message": message.toJson(),
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
