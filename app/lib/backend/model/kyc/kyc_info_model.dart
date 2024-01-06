// To parse this JSON data, do
//
//     final kycInfoModel = kycInfoModelFromJson(jsonString);

import 'dart:convert';

KycInfoModel kycInfoModelFromJson(String str) =>
    KycInfoModel.fromJson(json.decode(str));

String kycInfoModelToJson(KycInfoModel data) => json.encode(data.toJson());

class KycInfoModel {
  Message message;
  Data data;

  KycInfoModel({
    required this.message,
    required this.data,
  });

  factory KycInfoModel.fromJson(Map<String, dynamic> json) => KycInfoModel(
        message: Message.fromJson(json["message"]),
        data: Data.fromJson(json["data"]),
      );

  Map<String, dynamic> toJson() => {
        "message": message.toJson(),
        "data": data.toJson(),
      };
}

class Data {
  String statusInfo;
  int kycStatus;
  List<InputField> inputFields;

  Data({
    required this.statusInfo,
    required this.kycStatus,
    required this.inputFields,
  });

  factory Data.fromJson(Map<String, dynamic> json) => Data(
        statusInfo: json["status_info"],
        kycStatus: json["kyc_status"],
        inputFields: List<InputField>.from(
            json["input_fields"].map((x) => InputField.fromJson(x))),
      );

  Map<String, dynamic> toJson() => {
        "status_info": statusInfo,
        "kyc_status": kycStatus,
        "input_fields": List<dynamic>.from(inputFields.map((x) => x.toJson())),
      };
}

class InputField {
  String type;
  String label;
  String name;
  bool required;
  Validation validation;

  InputField({
    required this.type,
    required this.label,
    required this.name,
    required this.required,
    required this.validation,
  });

  factory InputField.fromJson(Map<String, dynamic> json) => InputField(
        type: json["type"],
        label: json["label"],
        name: json["name"],
        required: json["required"],
        validation: Validation.fromJson(json["validation"]),
      );

  Map<String, dynamic> toJson() => {
        "type": type,
        "label": label,
        "name": name,
        "required": required,
        "validation": validation.toJson(),
      };
}

class Validation {
  dynamic max;
  int min;
  List<String> mimes;
  List<String> options;
  bool required;

  Validation({
    required this.max,
    required this.min,
    required this.mimes,
    required this.options,
    required this.required,
  });

  factory Validation.fromJson(Map<String, dynamic> json) => Validation(
        max: json["max"],
        min: json["min"],
        mimes: List<String>.from(json["mimes"].map((x) => x)),
        options: List<String>.from(json["options"].map((x) => x)),
        required: json["required"],
      );

  Map<String, dynamic> toJson() => {
        "max": max,
        "min": min,
        "mimes": List<dynamic>.from(mimes.map((x) => x)),
        "options": List<dynamic>.from(options.map((x) => x)),
        "required": required,
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
