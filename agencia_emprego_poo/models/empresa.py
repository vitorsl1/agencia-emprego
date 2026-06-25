from dataclasses import dataclass


@dataclass
class Empresa:
    cnpj: str
    razao_social: str
    endereco: str

    def __str__(self) -> str:
        return f"{self.razao_social} - CNPJ: {self.cnpj}"
