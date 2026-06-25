from __future__ import annotations

import sqlite3
from pathlib import Path


class ConexaoBD:
    _instances: dict[str, "ConexaoBD"] = {}

    def __new__(cls, db_path: str = "agencia.db") -> "ConexaoBD":
        key = db_path
        if key not in cls._instances:
            cls._instances[key] = super().__new__(cls)
        return cls._instances[key]

    def __init__(self, db_path: str = "agencia.db") -> None:
        if hasattr(self, "_initialized") and self._initialized:
            return
        self.db_path = db_path
        self.conn = self._conectar()
        self._criar_tabelas()
        self._initialized = True

    def _conectar(self) -> sqlite3.Connection:
        try:
            path = self.db_path
            if path != ":memory:":
                Path(path).parent.mkdir(parents=True, exist_ok=True)
            conn = sqlite3.connect(path)
            conn.row_factory = sqlite3.Row
            conn.execute("PRAGMA foreign_keys = ON")
            return conn
        except sqlite3.Error as exc:
            raise ConnectionError("Falha ao conectar ao banco de dados") from exc

    def _criar_tabelas(self) -> None:
        self.conn.executescript(
            """
            CREATE TABLE IF NOT EXISTS profissional (
                cpf TEXT PRIMARY KEY,
                nome TEXT NOT NULL,
                endereco TEXT NOT NULL,
                data_nascimento TEXT NOT NULL,
                profissao TEXT NOT NULL
            );

            CREATE TABLE IF NOT EXISTS empresa (
                cnpj TEXT PRIMARY KEY,
                razao_social TEXT NOT NULL,
                endereco TEXT NOT NULL
            );

            CREATE TABLE IF NOT EXISTS contrato (
                numero INTEGER PRIMARY KEY AUTOINCREMENT,
                cpf_profissional TEXT NOT NULL,
                cnpj_empresa TEXT NOT NULL,
                data_inicio TEXT NOT NULL,
                data_termino TEXT NOT NULL,
                valor_hora REAL NOT NULL,
                FOREIGN KEY (cpf_profissional) REFERENCES profissional(cpf) ON DELETE RESTRICT,
                FOREIGN KEY (cnpj_empresa) REFERENCES empresa(cnpj) ON DELETE RESTRICT
            );
            """
        )
        self.conn.commit()

    def __enter__(self) -> sqlite3.Connection:
        return self.conn

    def __exit__(self, exc_type, exc, tb) -> None:
        if exc:
            self.conn.rollback()
        else:
            self.conn.commit()

    def close(self) -> None:
        self.conn.close()
        self._initialized = False
        self._instances.pop(self.db_path, None)
