BEGIN TRANSACTION;
CREATE TABLE IF NOT EXISTS "cache" (
	"key"	varchar NOT NULL,
	"value"	text NOT NULL,
	"expiration"	integer NOT NULL,
	PRIMARY KEY("key")
);
CREATE TABLE IF NOT EXISTS "cache_locks" (
	"key"	varchar NOT NULL,
	"owner"	varchar NOT NULL,
	"expiration"	integer NOT NULL,
	PRIMARY KEY("key")
);
CREATE TABLE IF NOT EXISTS "failed_jobs" (
	"id"	integer NOT NULL,
	"uuid"	varchar NOT NULL,
	"connection"	text NOT NULL,
	"queue"	text NOT NULL,
	"payload"	text NOT NULL,
	"exception"	text NOT NULL,
	"failed_at"	datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY("id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "infos" (
	"id"	integer NOT NULL,
	"nama_lengkap"	varchar NOT NULL,
	"telepon"	varchar,
	"ip_address"	varchar NOT NULL,
	"info_aktifitas"	varchar NOT NULL,
	"tanggal_kejadian"	datetime NOT NULL,
	"level"	varchar,
	"created_at"	datetime,
	"updated_at"	datetime,
	PRIMARY KEY("id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "invoices" (
	"id"	integer NOT NULL,
	"subscription_id"	integer NOT NULL,
	"file_path"	varchar NOT NULL,
	"created_at"	datetime,
	"updated_at"	datetime,
	PRIMARY KEY("id" AUTOINCREMENT),
	FOREIGN KEY("subscription_id") REFERENCES "subscriptions"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "job_batches" (
	"id"	varchar NOT NULL,
	"name"	varchar NOT NULL,
	"total_jobs"	integer NOT NULL,
	"pending_jobs"	integer NOT NULL,
	"failed_jobs"	integer NOT NULL,
	"failed_job_ids"	text NOT NULL,
	"options"	text,
	"cancelled_at"	integer,
	"created_at"	integer NOT NULL,
	"finished_at"	integer,
	PRIMARY KEY("id")
);
CREATE TABLE IF NOT EXISTS "jobs" (
	"id"	integer NOT NULL,
	"queue"	varchar NOT NULL,
	"payload"	text NOT NULL,
	"attempts"	integer NOT NULL,
	"reserved_at"	integer,
	"available_at"	integer NOT NULL,
	"created_at"	integer NOT NULL,
	PRIMARY KEY("id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "migrations" (
	"id"	integer NOT NULL,
	"migration"	varchar NOT NULL,
	"batch"	integer NOT NULL,
	PRIMARY KEY("id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "pakets" (
	"id"	integer NOT NULL,
	"nama"	varchar NOT NULL,
	"harga_bulanan"	varchar NOT NULL,
	"mikrotik"	varchar NOT NULL,
	"langganan"	varchar NOT NULL,
	"voucher"	varchar NOT NULL,
	"user_online"	varchar NOT NULL,
	"vpn_tunnel"	tinyint(1) NOT NULL DEFAULT '0',
	"vpn_remote"	tinyint(1) NOT NULL DEFAULT '0',
	"whatsapp_gateway"	tinyint(1) NOT NULL DEFAULT '0',
	"payment_gateway"	tinyint(1) NOT NULL DEFAULT '0',
	"custom_domain"	tinyint(1) NOT NULL DEFAULT '0',
	"client_area"	tinyint(1) NOT NULL DEFAULT '0',
	"harga_tahunan"	varchar NOT NULL,
	"created_at"	datetime,
	"updated_at"	datetime,
	PRIMARY KEY("id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "password_reset_tokens" (
	"telepon"	varchar NOT NULL,
	"token"	varchar NOT NULL,
	"created_at"	datetime,
	PRIMARY KEY("telepon")
);
CREATE TABLE IF NOT EXISTS "personal_access_tokens" (
	"id"	integer NOT NULL,
	"tokenable_type"	varchar NOT NULL,
	"tokenable_id"	integer NOT NULL,
	"name"	text NOT NULL,
	"token"	varchar NOT NULL,
	"abilities"	text,
	"last_used_at"	datetime,
	"expires_at"	datetime,
	"created_at"	datetime,
	"updated_at"	datetime,
	PRIMARY KEY("id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "profile_vouchers" (
	"id"	integer NOT NULL,
	"nama_profile"	varchar NOT NULL,
	"warna_voucher"	varchar,
	"mikrotik_group"	varchar NOT NULL,
	"mikrotik_address_list"	varchar,
	"mikrotik_rate_limit"	varchar,
	"shared"	integer NOT NULL DEFAULT '1',
	"kuota"	integer NOT NULL DEFAULT '0',
	"kuota_satuan"	varchar NOT NULL DEFAULT 'UNLIMITED',
	"durasi"	integer NOT NULL DEFAULT '0',
	"durasi_satuan"	varchar NOT NULL DEFAULT 'UNLIMITED',
	"masa_aktif"	integer NOT NULL DEFAULT '1',
	"masa_aktif_satuan"	varchar NOT NULL DEFAULT 'HARI',
	"hjk"	numeric NOT NULL DEFAULT '0',
	"komisi"	numeric NOT NULL DEFAULT '0',
	"hpp"	numeric NOT NULL DEFAULT '0',
	"created_at"	datetime,
	"updated_at"	datetime,
	PRIMARY KEY("id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "resellers" (
	"id"	integer NOT NULL,
	"nama_lengkap"	varchar NOT NULL,
	"no_identitas"	varchar,
	"telepon"	varchar,
	"alamat"	text,
	"username"	varchar NOT NULL,
	"password"	varchar NOT NULL,
	"tgl_bergabung"	date,
	"limit_hutang"	numeric NOT NULL DEFAULT '0',
	"kode_unik"	varchar NOT NULL DEFAULT '0',
	"hak_akses_router"	text,
	"hak_akses_server"	text,
	"hak_akses_profile"	text,
	"created_at"	datetime,
	"updated_at"	datetime,
	PRIMARY KEY("id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "routers" (
	"id"	integer NOT NULL,
	"nama_router"	varchar NOT NULL,
	"tipe_koneksi"	varchar NOT NULL CHECK("tipe_koneksi" IN ('ip_public', 'vpn_radius')),
	"ip_address"	varchar,
	"secret"	varchar,
	"online"	tinyint(1) NOT NULL DEFAULT '0',
	"script_path"	varchar,
	"snmp"	varchar,
	"created_at"	datetime,
	"updated_at"	datetime,
	PRIMARY KEY("id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "sessions" (
	"id"	varchar NOT NULL,
	"user_id"	integer,
	"ip_address"	varchar,
	"user_agent"	text,
	"payload"	text NOT NULL,
	"last_activity"	integer NOT NULL,
	PRIMARY KEY("id")
);
CREATE TABLE IF NOT EXISTS "stok_vouchers" (
	"id"	integer NOT NULL,
	"reseller_id"	integer,
	"profile_voucher_id"	integer,
	"username"	varchar NOT NULL,
	"password"	varchar NOT NULL,
	"router"	varchar,
	"server"	varchar,
	"outlet"	varchar,
	"hpp"	numeric NOT NULL DEFAULT '0',
	"komisi"	numeric NOT NULL DEFAULT '0',
	"hjk"	numeric NOT NULL DEFAULT '0',
	"saldo"	tinyint(1) NOT NULL DEFAULT '1',
	"admin"	varchar,
	"kode"	varchar,
	"prefix"	varchar,
	"panjang_karakter"	integer NOT NULL DEFAULT '6',
	"jenis_voucher"	varchar,
	"kode_kombinasi"	varchar,
	"jumlah"	integer NOT NULL DEFAULT '1',
	"total_komisi"	numeric NOT NULL DEFAULT '0',
	"total_hpp"	numeric NOT NULL DEFAULT '0',
	"tgl_aktif"	datetime,
	"tgl_expired"	datetime,
	"upload_bytes"	integer NOT NULL DEFAULT '0',
	"download_bytes"	integer NOT NULL DEFAULT '0',
	"durasi_detik"	integer NOT NULL DEFAULT '0',
	"mac"	varchar,
	"tgl_pembuatan"	datetime,
	"created_at"	datetime,
	"updated_at"	datetime,
	PRIMARY KEY("id" AUTOINCREMENT),
	FOREIGN KEY("profile_voucher_id") REFERENCES "profile_vouchers"("id") on delete set null,
	FOREIGN KEY("reseller_id") REFERENCES "resellers"("id") on delete set null
);
CREATE TABLE IF NOT EXISTS "subscriptions" (
	"id"	integer NOT NULL,
	"user_id"	integer NOT NULL,
	"data_center"	varchar NOT NULL CHECK("data_center" IN ('IDC 3D JAKARTA', 'NCIX PEKANBARU')),
	"subdomain_url"	varchar NOT NULL,
	"paket_id"	integer NOT NULL,
	"siklus"	varchar NOT NULL CHECK("siklus" IN ('bulanan', 'tahunan')),
	"harga"	numeric NOT NULL,
	"nama_perusahaan"	varchar NOT NULL,
	"provinsi"	varchar NOT NULL,
	"kabupaten"	varchar NOT NULL,
	"alamat"	text NOT NULL,
	"telepon"	varchar NOT NULL,
	"setuju"	tinyint(1) NOT NULL DEFAULT '0',
	"status"	varchar NOT NULL DEFAULT 'belum dibayar' CHECK("status" IN ('dibayar', 'belum dibayar')),
	"created_at"	datetime,
	"updated_at"	datetime,
	PRIMARY KEY("id" AUTOINCREMENT),
	FOREIGN KEY("paket_id") REFERENCES "pakets"("id") on delete cascade,
	FOREIGN KEY("user_id") REFERENCES "users"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "users" (
	"id"	integer NOT NULL,
	"name"	varchar NOT NULL,
	"telepon"	varchar NOT NULL,
	"password"	varchar NOT NULL,
	"level"	varchar NOT NULL DEFAULT 'user',
	"remember_token"	varchar,
	"created_at"	datetime,
	"updated_at"	datetime,
	PRIMARY KEY("id" AUTOINCREMENT)
);
INSERT INTO "migrations" VALUES (1,'0001_01_01_000000_create_users_table',1);
INSERT INTO "migrations" VALUES (2,'0001_01_01_000001_create_cache_table',1);
INSERT INTO "migrations" VALUES (3,'0001_01_01_000002_create_jobs_table',1);
INSERT INTO "migrations" VALUES (4,'2025_08_01_024809_create_pakets_table',1);
INSERT INTO "migrations" VALUES (5,'2025_08_07_031110_create_subscriptions_table',1);
INSERT INTO "migrations" VALUES (6,'2025_08_09_085929_create_resellers_table',1);
INSERT INTO "migrations" VALUES (7,'2025_08_09_100033_create_personal_access_tokens_table',1);
INSERT INTO "migrations" VALUES (8,'2025_08_09_101628_create_profile_vouchers_table',1);
INSERT INTO "migrations" VALUES (9,'2025_08_12_020202_create_stok_vouchers_table',1);
INSERT INTO "migrations" VALUES (10,'2025_08_13_020637_create_routers_table',1);
INSERT INTO "migrations" VALUES (11,'2025_08_20_025641_create_infos_table',1);
INSERT INTO "migrations" VALUES (12,'2025_10_23_204117_create_invoices_table',1);
CREATE UNIQUE INDEX IF NOT EXISTS "failed_jobs_uuid_unique" ON "failed_jobs" (
	"uuid"
);
CREATE INDEX IF NOT EXISTS "jobs_queue_index" ON "jobs" (
	"queue"
);
CREATE INDEX IF NOT EXISTS "personal_access_tokens_expires_at_index" ON "personal_access_tokens" (
	"expires_at"
);
CREATE UNIQUE INDEX IF NOT EXISTS "personal_access_tokens_token_unique" ON "personal_access_tokens" (
	"token"
);
CREATE INDEX IF NOT EXISTS "personal_access_tokens_tokenable_type_tokenable_id_index" ON "personal_access_tokens" (
	"tokenable_type",
	"tokenable_id"
);
CREATE UNIQUE INDEX IF NOT EXISTS "resellers_username_unique" ON "resellers" (
	"username"
);
CREATE INDEX IF NOT EXISTS "sessions_last_activity_index" ON "sessions" (
	"last_activity"
);
CREATE INDEX IF NOT EXISTS "sessions_user_id_index" ON "sessions" (
	"user_id"
);
CREATE UNIQUE INDEX IF NOT EXISTS "stok_vouchers_username_unique" ON "stok_vouchers" (
	"username"
);
CREATE UNIQUE INDEX IF NOT EXISTS "subscriptions_subdomain_url_unique" ON "subscriptions" (
	"subdomain_url"
);
CREATE UNIQUE INDEX IF NOT EXISTS "users_telepon_unique" ON "users" (
	"telepon"
);
COMMIT;
