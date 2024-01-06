
class StripeSensitiveModel {
  Message message;
  Data data;

  StripeSensitiveModel({
    required this.message,
    required this.data,
  });

  factory StripeSensitiveModel.fromJson(Map<String, dynamic> json) =>
      StripeSensitiveModel(
        message: Message.fromJson(json["message"]),
        data: Data.fromJson(json["data"]),
      );

  Map<String, dynamic> toJson() => {
        "message": message.toJson(),
        "data": data.toJson(),
      };
}

class Data {
  SensitiveData sensitiveData;

  Data({
    required this.sensitiveData,
  });

  factory Data.fromJson(Map<String, dynamic> json) => Data(
        sensitiveData: SensitiveData.fromJson(json["sensitive_data"]),
      );

  Map<String, dynamic> toJson() => {
        "sensitive_data": sensitiveData.toJson(),
      };
}

class SensitiveData {
  bool status;
  String message;
  String number;
  String cvc;

  SensitiveData({
    required this.status,
    required this.message,
    required this.number,
    required this.cvc,
  });

  factory SensitiveData.fromJson(Map<String, dynamic> json) => SensitiveData(
        status: json["status"],
        message: json["message"],
        number: json["number"],
        cvc: json["cvc"],
      );

  Map<String, dynamic> toJson() => {
        "status": status,
        "message": message,
        "number": number,
        "cvc": cvc,
      };
}

class Message {
  List<String> success;

  Message({
    required this.success,
  });

  factory Message.fromJson(Map<String, dynamic> json) => Message(
        success: List<String>.from(json["success"].map((x) => x)),
      );

  Map<String, dynamic> toJson() => {
        "success": List<dynamic>.from(success.map((x) => x)),
      };
}
