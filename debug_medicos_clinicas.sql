-- Verificar associações de médicos e clínicas
SELECT 
    mc.id,
    mc.medico_id,
    mc.clinica_id,
    mc.empresa_id,
    mc.status,
    mc.data_associacao,
    m.nome AS nome_medico,
    c.nome_fantasia AS nome_clinica
FROM 
    medicos_clinicas mc
JOIN 
    medicos m ON mc.medico_id = m.id
JOIN 
    clinicas c ON mc.clinica_id = c.id
WHERE 
    mc.status = 'Ativo'
ORDER BY 
    c.nome_fantasia, 
    m.nome;
