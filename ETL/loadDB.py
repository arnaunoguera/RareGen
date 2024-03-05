import pymysql
import re
import xml.etree.ElementTree as ET


#Database connection
database = "RareGen";
host = "localhost";
user="arnau"; 
passwd = "DBW";

connection = pymysql.connect(host='localhost',
                user=user,
                password=passwd,
                db=database,
                charset='utf8mb4',
                autocommit=True
            )

## Turn off FKs
connection.cursor().execute("SET FOREIGN_KEY_CHECKS=0")

## Clean Tables !!
for tab in (
    'Author', 
    'Country', 
    'Country_has_Patient_Association', 
    'Disease', 
    'Disease_has_Mutation', 
    'Disease_has_Paper',
    'Disease_has_Patient_Association', 
    'Gene', 
    'Gene_alias', 
    'Journal', 
    'Login', 
    'Mutation', 
    'Mutation_type', 
    'Mutation_has_Paper', 
    'Paper', 
    'Paper_has_Author', 
    'Patient_Association', 
    'Publisher'
    ):
    try:
        print("Cleaning {}".format(tab))
        connection.cursor().execute("DELETE FROM "+ tab)
    except OSError as e:
        sys.exit(e.msg)

print('Success')

## DISEASE - GENE
sthEntryAlias = "INSERT INTO Gene_alias VALUES (%s,%s)"
sthEntryGene = "INSERT INTO Gene VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)"
GENES = []
with open("../data/disease_gene.xml") as f:
    tree = ET.parse('../data/disease_gene.xml')
    parser = ET.XMLParser(encoding='ISO-8859-1')
    root = tree.getroot()
    for child in root:
        if child.tag == 'DisorderList':
            for disorder in child:
                idDisease = disorder.attrib['id']
                for diseaseInfo in disorder:
                    if diseaseInfo.tag == "OrphaCode":
                        OrphaCode = diseaseInfo.text
                        #print(OrphaCode)
                    elif diseaseInfo.tag == "Name":
                        DiseaseName = diseaseInfo.text
                        #print(DiseaseName)
                    #print(diseaseInfo.tag, diseaseInfo.attrib)
                    elif diseaseInfo.tag == "DisorderGeneAssociationList":
                        for associationlist in diseaseInfo:
                            for association in associationlist:
                                if association.tag == "Gene":
                                    idGene = association.attrib['id']
                                    if idGene not in GENES:
                                        GeneLocus = ""
                                        GeneName = ""
                                        GeneType= ""
                                        GeneLocus = ""
                                        GeneSymbol = ""
                                        #print(idGene)
                                        for geneInfo in association:
                                            #print(geneInfo.tag, geneInfo.attrib)
                                            if geneInfo.tag == "Name":
                                                GeneName = geneInfo.text
                                                #print(GeneName)
                                            elif geneInfo.tag == "Symbol":
                                                GeneSymbol = geneInfo.text
                                                #print(GeneSymbol)
                                            elif geneInfo.tag == "SynonymList":
                                                GENEALIAS = []
                                                with connection.cursor() as c:
                                                    for synonym in geneInfo:
                                                        GeneSynonym = synonym.text
                                                        if GeneSynonym.lower() not in GENEALIAS:
                                                            #print(GeneSynonym)
                                                            c.execute(sthEntryAlias, (GeneSynonym, idGene))
                                                            GENEALIAS.append(GeneSynonym.lower())
                                                        #print(GeneSynonym)
                                            elif geneInfo.tag == "GeneType":
                                                for typename in geneInfo:
                                                    if typename.tag == "Name":
                                                        GeneType= typename.text
                                                        #print(GeneType)
                                            elif geneInfo.tag == "ExternalReferenceList":
                                                EnsemblID = ""
                                                GenatlasID = ""
                                                HgncID = ""
                                                OmimID = int()
                                                SwissprotID = ""
                                                for reference in geneInfo:
                                                    for referenceInfo in reference:
                                                        if referenceInfo.tag == 'Source':
                                                            Source = referenceInfo.text
                                                            #print(Source)
                                                        elif referenceInfo.tag == 'Reference':
                                                            if Source == "Ensembl":
                                                                EnsemblID = referenceInfo.text
                                                            elif Source == "Genatlas":
                                                                GenatlasID = referenceInfo.text
                                                            elif Source == "HGNC":
                                                                HgncID = referenceInfo.text
                                                            elif Source == "OMIM":
                                                                OmimID = referenceInfo.text
                                                            elif Source == "SwissProt":
                                                                SwissprotID = referenceInfo.text
                                                #print(EnsemblID, GenatlasID, HgncID, OmimID, ReactomeID, SwissprotID, sep= '\t')
                                            elif geneInfo.tag == "LocusList":
                                                for locus in geneInfo:
                                                    for locusInfo in locus:
                                                        if locusInfo.tag == 'GeneLocus':
                                                            GeneLocus = locusInfo.text
                                                            #print(GeneLocus)
                                        GENES.append(idGene)
                                        with connection.cursor() as c:
                                            c.execute(sthEntryGene, (idGene, GeneName, GeneType, GeneLocus, EnsemblID, OmimID, GenatlasID, HgncID, '', GeneSymbol, SwissprotID))
                                        print(GeneName)
                                elif association.tag == 'DisorderGeneAssociationType':
                                    for assocname in association:
                                        if assocname.tag == "Name":
                                            DGassocType = assocname.text
                                            #print(DGassocType)
                                #print(association.tag, association.attrib)
print('Success1')
connection.close()
print('Success')
