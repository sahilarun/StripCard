import 'dart:convert';

class TransationLogModel {
  Message? message;
  Data? data;

  TransationLogModel({
    this.message,
    this.data,
  });

  factory TransationLogModel.fromRawJson(String str) =>
      TransationLogModel.fromJson(json.decode(str));

  String toRawJson() => json.encode(toJson());

  factory TransationLogModel.fromJson(Map<String, dynamic> json) =>
      TransationLogModel(
        message:
            json["message"] == null ? null : Message.fromJson(json["message"]),
        data: json["data"] == null ? null : Data.fromJson(json["data"]),
      );

  Map<String, dynamic> toJson() => {
        "message": message?.toJson(),
        "data": data?.toJson(),
      };
}

class Data {
  TransactionTypes? transactionTypes;
  Transactions? transactions;

  Data({
    this.transactionTypes,
    this.transactions,
  });

  factory Data.fromRawJson(String str) => Data.fromJson(json.decode(str));

  String toRawJson() => json.encode(toJson());

  factory Data.fromJson(Map<String, dynamic> json) => Data(
        transactionTypes: json["transaction_types"] == null
            ? null
            : TransactionTypes.fromJson(json["transaction_types"]),
        transactions: json["transactions"] == null
            ? null
            : Transactions.fromJson(json["transactions"]),
      );

  Map<String, dynamic> toJson() => {
        "transaction_types": transactionTypes?.toJson(),
        "transactions": transactions?.toJson(),
      };
}

class TransactionTypes {
  String? addMoney;
  String? transferMoney;
  String? virtualCard;
  String? addSubBalance;

  TransactionTypes({
    this.addMoney,
    this.transferMoney,
    this.virtualCard,
    this.addSubBalance,
  });

  factory TransactionTypes.fromRawJson(String str) =>
      TransactionTypes.fromJson(json.decode(str));

  String toRawJson() => json.encode(toJson());

  factory TransactionTypes.fromJson(Map<String, dynamic> json) =>
      TransactionTypes(
        addMoney: json["add_money"],
        transferMoney: json["transfer_money"],
        virtualCard: json["virtual_card"],
        addSubBalance: json["add_sub_balance"],
      );

  Map<String, dynamic> toJson() => {
        "add_money": addMoney,
        "transfer_money": transferMoney,
        "virtual_card": virtualCard,
        "add_sub_balance": addSubBalance,
      };
}

class Transactions {
  List<AddMoney>? addMoney;
  List<SendMoney>? sendMoney;
  List<VirtualCard>? virtualCard;
  List<AddSubBalance>? addSubBalance;

  Transactions({
    this.addMoney,
    this.sendMoney,
    this.virtualCard,
    this.addSubBalance,
  });

  factory Transactions.fromRawJson(String str) =>
      Transactions.fromJson(json.decode(str));

  String toRawJson() => json.encode(toJson());

  factory Transactions.fromJson(Map<String, dynamic> json) => Transactions(
        addMoney: json["add_money"] == null
            ? []
            : List<AddMoney>.from(
                json["add_money"]!.map((x) => AddMoney.fromJson(x))),
        sendMoney: json["send_money"] == null
            ? []
            : List<SendMoney>.from(
                json["send_money"]!.map((x) => SendMoney.fromJson(x))),
        virtualCard: json["virtual_card"] == null
            ? []
            : List<VirtualCard>.from(
                json["virtual_card"]!.map((x) => VirtualCard.fromJson(x))),
        addSubBalance: json["add_sub_balance"] == null
            ? []
            : List<AddSubBalance>.from(
                json["add_sub_balance"]!.map((x) => AddSubBalance.fromJson(x))),
      );

  Map<String, dynamic> toJson() => {
        "add_money": addMoney == null
            ? []
            : List<dynamic>.from(addMoney!.map((x) => x.toJson())),
        "send_money": sendMoney == null
            ? []
            : List<dynamic>.from(sendMoney!.map((x) => x.toJson())),
        "virtual_card": virtualCard == null
            ? []
            : List<dynamic>.from(virtualCard!.map((x) => x.toJson())),
        "add_sub_balance": addSubBalance == null
            ? []
            : List<dynamic>.from(addSubBalance!.map((x) => x.toJson())),
      };
}

class AddMoney {
  int? id;
  String? trx;
  String? gatewayName;
  String? transactionType;
  String? requestAmount;
  String? payable;
  String? exchangeRate;
  String? totalCharge;
  String? currentBalance;
  String? status;
  DateTime? dateTime;
  StatusInfo? statusInfo;
  String? rejectionReason;
  String? transactionHeading;
  String? receiveAmount;
  String? remark;
  String? type;
  String? recipientReceived;
  String? cardAmount;
  String? cardNumber;

  AddMoney({
    this.id,
    this.trx,
    this.gatewayName,
    this.transactionType,
    this.requestAmount,
    this.payable,
    this.exchangeRate,
    this.totalCharge,
    this.currentBalance,
    this.status,
    this.dateTime,
    this.statusInfo,
    this.rejectionReason,
    this.transactionHeading,
    this.receiveAmount,
    this.remark,
    this.type,
    this.recipientReceived,
    this.cardAmount,
    this.cardNumber,
  });

  factory AddMoney.fromRawJson(String str) =>
      AddMoney.fromJson(json.decode(str));

  String toRawJson() => json.encode(toJson());

  factory AddMoney.fromJson(Map<String, dynamic> json) => AddMoney(
        id: json["id"],
        trx: json["trx"],
        gatewayName: json["gateway_name"],
        transactionType: json["transaction_type"],
        requestAmount: json["request_amount"],
        payable: json["payable"],
        exchangeRate: json["exchange_rate"],
        totalCharge: json["total_charge"],
        currentBalance: json["current_balance"],
        status: json["status"],
        dateTime: json["date_time"] == null
            ? null
            : DateTime.parse(json["date_time"]),
        statusInfo: json["status_info"] == null
            ? null
            : StatusInfo.fromJson(json["status_info"]),
        rejectionReason: json["rejection_reason"],
        transactionHeading: json["transaction_heading"],
        receiveAmount: json["receive_amount"],
        remark: json["remark"],
        type: json["type"],
        recipientReceived: json["recipient_received"],
        cardAmount: json["card_amount"],
        cardNumber: json["card_number"],
      );

  Map<String, dynamic> toJson() => {
        "id": id,
        "trx": trx,
        "gateway_name": gatewayName,
        "transaction_type": transactionType,
        "request_amount": requestAmount,
        "payable": payable,
        "exchange_rate": exchangeRate,
        "total_charge": totalCharge,
        "current_balance": currentBalance,
        "status": status,
        "date_time": dateTime?.toIso8601String(),
        "status_info": statusInfo?.toJson(),
        "rejection_reason": rejectionReason,
        "transaction_heading": transactionHeading,
        "receive_amount": receiveAmount,
        "remark": remark,
        "type": type,
        "recipient_received": recipientReceived,
        "card_amount": cardAmount,
        "card_number": cardNumber,
      };
}

class SendMoney {
  int? id;
  String? type;
  String? trx;
  String? transactionType;
  String? transactionHeading;
  String? requestAmount;
  String? totalCharge;
  String? payable;
  String? recipientReceived;
  String? currentBalance;
  String? status;
  DateTime? dateTime;
  StatusInfo? statusInfo;

  SendMoney({
    this.id,
    this.type,
    this.trx,
    this.transactionType,
    this.transactionHeading,
    this.requestAmount,
    this.totalCharge,
    this.payable,
    this.recipientReceived,
    this.currentBalance,
    this.status,
    this.dateTime,
    this.statusInfo,
  });

  factory SendMoney.fromRawJson(String str) =>
      SendMoney.fromJson(json.decode(str));

  String toRawJson() => json.encode(toJson());

  factory SendMoney.fromJson(Map<String, dynamic> json) => SendMoney(
        id: json["id"],
        type: json["type"],
        trx: json["trx"],
        transactionType: json["transaction_type"],
        transactionHeading: json["transaction_heading"],
        requestAmount: json["request_amount"],
        totalCharge: json["total_charge"],
        payable: json["payable"],
        recipientReceived: json["recipient_received"],
        currentBalance: json["current_balance"],
        status: json["status"],
        dateTime: json["date_time"] == null
            ? null
            : DateTime.parse(json["date_time"]),
        statusInfo: json["status_info"] == null
            ? null
            : StatusInfo.fromJson(json["status_info"]),
      );

  Map<String, dynamic> toJson() => {
        "id": id,
        "type": type,
        "trx": trx,
        "transaction_type": transactionType,
        "transaction_heading": transactionHeading,
        "request_amount": requestAmount,
        "total_charge": totalCharge,
        "payable": payable,
        "recipient_received": recipientReceived,
        "current_balance": currentBalance,
        "status": status,
        "date_time": dateTime?.toIso8601String(),
        "status_info": statusInfo?.toJson(),
      };
}

class VirtualCard {
  int? id;
  String? trx;
  String? transactionType;
  String? requestAmount;
  String? payable;
  String? totalCharge;
  String? cardAmount;
  String? cardNumber;
  String? currentBalance;
  String? status;
  DateTime? dateTime;
  StatusInfo? statusInfo;

  VirtualCard({
    this.id,
    this.trx,
    this.transactionType,
    this.requestAmount,
    this.payable,
    this.totalCharge,
    this.cardAmount,
    this.cardNumber,
    this.currentBalance,
    this.status,
    this.dateTime,
    this.statusInfo,
  });

  factory VirtualCard.fromRawJson(String str) =>
      VirtualCard.fromJson(json.decode(str));

  String toRawJson() => json.encode(toJson());

  factory VirtualCard.fromJson(Map<String, dynamic> json) => VirtualCard(
        id: json["id"],
        trx: json["trx"],
        transactionType: json["transaction_type"],
        requestAmount: json["request_amount"],
        payable: json["payable"],
        totalCharge: json["total_charge"],
        cardAmount: json["card_amount"],
        cardNumber: json["card_number"],
        currentBalance: json["current_balance"],
        status: json["status"],
        dateTime: json["date_time"] == null
            ? null
            : DateTime.parse(json["date_time"]),
        statusInfo: json["status_info"] == null
            ? null
            : StatusInfo.fromJson(json["status_info"]),
      );

  Map<String, dynamic> toJson() => {
        "id": id,
        "trx": trx,
        "transaction_type": transactionType,
        "request_amount": requestAmount,
        "payable": payable,
        "total_charge": totalCharge,
        "card_amount": cardAmount,
        "card_number": cardNumber,
        "current_balance": currentBalance,
        "status": status,
        "date_time": dateTime?.toIso8601String(),
        "status_info": statusInfo?.toJson(),
      };
}

class AddSubBalance {
  int? id;
  String? trx;
  String? transactionType;
  String? transactionHeading;
  String? requestAmount;
  String? currentBalance;
  String? receiveAmount;
  String? exchangeRate;
  String? totalCharge;
  String? remark;
  String? status;
  DateTime? dateTime;
  StatusInfo? statusInfo;

  AddSubBalance({
    this.id,
    this.trx,
    this.transactionType,
    this.transactionHeading,
    this.requestAmount,
    this.currentBalance,
    this.receiveAmount,
    this.exchangeRate,
    this.totalCharge,
    this.remark,
    this.status,
    this.dateTime,
    this.statusInfo,
  });

  factory AddSubBalance.fromRawJson(String str) =>
      AddSubBalance.fromJson(json.decode(str));

  String toRawJson() => json.encode(toJson());

  factory AddSubBalance.fromJson(Map<String, dynamic> json) => AddSubBalance(
        id: json["id"],
        trx: json["trx"],
        transactionType: json["transaction_type"],
        transactionHeading: json["transaction_heading"],
        requestAmount: json["request_amount"],
        currentBalance: json["current_balance"],
        receiveAmount: json["receive_amount"],
        exchangeRate: json["exchange_rate"],
        totalCharge: json["total_charge"],
        remark: json["remark"],
        status: json["status"],
        dateTime: json["date_time"] == null
            ? null
            : DateTime.parse(json["date_time"]),
        statusInfo: json["status_info"] == null
            ? null
            : StatusInfo.fromJson(json["status_info"]),
      );

  Map<String, dynamic> toJson() => {
        "id": id,
        "trx": trx,
        "transaction_type": transactionType,
        "transaction_heading": transactionHeading,
        "request_amount": requestAmount,
        "current_balance": currentBalance,
        "receive_amount": receiveAmount,
        "exchange_rate": exchangeRate,
        "total_charge": totalCharge,
        "remark": remark,
        "status": status,
        "date_time": dateTime?.toIso8601String(),
        "status_info": statusInfo?.toJson(),
      };
}

class StatusInfo {
  int? success;
  int? pending;
  int? rejected;

  StatusInfo({
    this.success,
    this.pending,
    this.rejected,
  });

  factory  StatusInfo.fromRawJson(String str) =>
           StatusInfo.fromJson(json.decode(str));

  String toRawJson() => json.encode(toJson());

  factory StatusInfo.fromJson(Map<String, dynamic> json) => StatusInfo(
        success: json["success"],
        pending: json["pending"],
        rejected: json["rejected"],
      );

  Map<String, dynamic> toJson() => {
        "success": success,
        "pending": pending,
        "rejected": rejected,
      };
}

class Message {
  List<String>? success;

  Message({
    this.success,
  });

  factory Message.fromRawJson(String str) => Message.fromJson(json.decode(str));

  String toRawJson() => json.encode(toJson());

  factory Message.fromJson(Map<String, dynamic> json) => Message(
        success: json["success"] == null
            ? []
            : List<String>.from(json["success"]!.map((x) => x)),
      );

  Map<String, dynamic> toJson() => {
        "success":
            success == null ? [] : List<dynamic>.from(success!.map((x) => x)),
      };
}
